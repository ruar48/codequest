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

        $validatedData = $request->validate([
            'level_number' => 'required|integer',
            'stars' => 'required|integer|min:0|max:3',
            'points' => 'required|integer|min:0',
            'user_id' => 'required|integer|exists:users,id', // Ensure user exists
        ]);

        $userId = $validatedData['user_id'];

        Log::info("Extracted User ID: $userId");

        $level = Level::updateOrCreate(
            ['user_id' => $userId, 'level_number' => $validatedData['level_number']],
            ['stars' => $validatedData['stars'], 'points' => $validatedData['points']]
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
}
