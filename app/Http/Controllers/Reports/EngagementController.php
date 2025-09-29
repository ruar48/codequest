<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\Models\Tips;
use Carbon\Carbon;
use DB;
use App\Models\ExecutedCode;
use App\Models\TestPerformance;
use App\Models\Question;
class EngagementController extends Controller
{
    public function engagment()
    {
        // Total players
        $totalPlayers = User::count();

        // Active sessions (last 24 hours)
        $activeSessions = DB::table('sessions')
            ->where('last_activity', '>=', now()->subDay()->timestamp)
            ->count();

        // PHP Execution Statistics
        $phpExecutions = [
            'total' => ExecutedCode::count(),
            'successful' => ExecutedCode::where('is_error', false)->count(),
            'errors' => ExecutedCode::where('is_error', true)->count(),
        ];

        // Most completed levels
        $mostCompletedLevels = Level::select('level_number', DB::raw('COUNT(*) as completion_count'))
            ->groupBy('level_number')
            ->orderByDesc('completion_count')
            ->limit(5)
            ->get();

        // Average points and stars
        $averagePoints = Level::avg('points');
        $averageStars = Level::avg('stars');

        // Total tips used
        $totalTipsUsed = Tips::count();

        return view('admin.engagement', compact(
            'totalPlayers',
            'activeSessions',
            'phpExecutions',
            'mostCompletedLevels',
            'averagePoints',
            'averageStars',
            'totalTipsUsed'
        ));

    }


    public function logs()
    {
        $logs = ExecutedCode::with('user')->orderByDesc('created_at')->get();

        return view('admin.code', compact('logs'));
    }

    public function progress()
    {
        // Fetch user progress with user details
        $progress = Level::with('user')->orderBy('level_number', 'asc')->get();

        return view('admin.progress', compact('progress'));
    }


    public function testProgress()
    {
        // Fetch all test performance records with related user and question data
        $testPerformances = TestPerformance::with(['user', 'question'])->get();

        return view('admin.test_progress', compact('testPerformances'));
    }


    public function getUserHistory(Request $request)
{
    $userId = $request->input('user_id'); // or use auth()->id() if token based

    $history = TestPerformance::with('question')
        ->where('user_id', $userId)
        ->get()
        ->map(function ($entry) {
            return [
                'question' => $entry->question->question ?? 'N/A',
                'answer' => $entry->answer,
                'result' => $entry->is_correct ? '✅ Correct' : '❌ Wrong',
                'points' => $entry->points . ' pts',
                'created_at' => $entry->created_at->toISOString()
            ];
        });

    return response()->json([
        'status' => 'success',
        'student_id' => $userId,
        'history' => $history
    ]);
}

}
