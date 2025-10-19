<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LevelController extends Controller
{
    public function updateLevel(Request $request)
    {
        Log::info('Incoming request:', $request->all());

        try {
            $validatedData = $request->validate([
                'level_number' => 'required|integer',
                'stars' => 'required|integer|min:0|max:3',
                'points_awarded' => 'required|integer|min:0',
                'user_id' => 'required|integer|exists:users,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation errors:', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        }

        Log::error('Validation errors:', $request->all());

        $userId = $validatedData['user_id'];

        Log::info("Extracted User ID: $userId");

        $level = Level::updateOrCreate(
            ['user_id' => $userId, 'level_number' => $validatedData['level_number']],
            ['stars' => $validatedData['stars'], 'points' => $validatedData['points_awarded']]
        );


        Log::info('Level updated:', ['level' => $level]);

        return response()->json(['message' => 'Level updated successfully', 'data' => $level]);
    }

    // Future Unlock Level Code
    // public function unlockNextLevel()
    // {
    //     $userId = Auth::id();
    //     $highestLevel = Level::where('user_id', $userId)->max('level_number');
    //
    //     return response()->json([
    //         'next_level_unlocked' => $highestLevel + 1,
    //     ]);
    // }

    public function getUserLevels($id)
    {
        $highestLevel = Level::where('user_id', $id)->max('level_number');

        $levels = Level::where('user_id', $id)->get();

        return response()->json([
            'next_level_unlocked' => $highestLevel + 1,
            'levels' => $levels
        ]);
    }

    public function getUserLevelHistory($id)
{
    // Fetch all levels of the user
    $levels = Level::where('user_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    // Transform to history messages
    $history = $levels->map(function ($level) {
        return [
            'message' => "✅ Completed Level {$level->level_number} with {$level->stars} Stars and {$level->points} Points",
            'level_number' => $level->level_number,
            'stars' => $level->stars,
            'points' => $level->points,
            'created_at' => $level->created_at->toDateTimeString(),
        ];
    });

    return response()->json([
        'status' => 'success',
        'user_id' => $id,
        'history' => $history
    ]);
}


}
