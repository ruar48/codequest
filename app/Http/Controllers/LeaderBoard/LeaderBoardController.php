<?php

namespace App\Http\Controllers\LeaderBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\Models\ExecutedCode;
use DB;
class LeaderBoardController extends Controller
{
    public function leaderboards()
    {
        // Get leaderboard data: Total points and stars per user
        $leaderboardData = Level::select('user_id')
            ->selectRaw('SUM(points) as total_points')
            ->selectRaw('SUM(stars) as total_stars')
            ->groupBy('user_id')
            ->orderByDesc('total_points') // Rank based on points first
            ->orderByDesc('total_stars')  // If points are the same, rank by stars
            ->get();

        // Fetch user data (e.g., names)
        foreach ($leaderboardData as $entry) {
            $user = User::find($entry->user_id);
            $entry->username = $user ? $user->email : 'Unknown';
        }

        return view('admin.leaderboard', compact('leaderboardData'));
    }


    public function analyticsreport(Request $request)
    {
        // Fetch leaderboard data: total points & stars per player
        $leaderboardData = Level::select('user_id')
            ->selectRaw('SUM(points) as total_points')
            ->selectRaw('SUM(stars) as total_stars')
            ->selectRaw('COUNT(DISTINCT level_number) as levels_completed')
            ->groupBy('user_id')
            ->orderByDesc('total_points')
            ->orderByDesc('total_stars')
            ->get();

        // Fetch player details
        foreach ($leaderboardData as $entry) {
            $user = User::find($entry->user_id);
            $entry->username = $user ? $user->email : 'Unknown';
        }

        // Get total players
        $totalPlayers = User::where('role', 'player')->count();

        // Get average points and stars per player
        $averagePoints = Level::avg('points');
        $averageStars = Level::avg('stars');

        // Get level-based performance
        $levelPerformance = Level::select('level_number')
            ->selectRaw('AVG(stars) as avg_stars')
            ->selectRaw('AVG(points) as avg_points')
            ->selectRaw('COUNT(user_id) as attempts')
            ->groupBy('level_number')
            ->orderBy('level_number')
            ->get();

        // Get PHP execution stats (successful vs. errors)
        $phpExecutions = ExecutedCode::selectRaw('
                SUM(CASE WHEN is_error = 0 THEN 1 ELSE 0 END) as successful,
                SUM(CASE WHEN is_error = 1 THEN 1 ELSE 0 END) as errors
            ')
            ->first();

        return view('admin.analytics_report', compact(
            'leaderboardData',
            'totalPlayers',
            'averagePoints',
            'averageStars',
            'levelPerformance',
            'phpExecutions'
        ));
    }
}
