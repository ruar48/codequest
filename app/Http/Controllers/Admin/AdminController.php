<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Get average stars per level & star distribution
        $progressData = Level::select('level_number')
            ->selectRaw('AVG(stars) as avg_stars')
            ->selectRaw('SUM(CASE WHEN stars = 3 THEN 1 ELSE 0 END) as three_stars')
            ->selectRaw('SUM(CASE WHEN stars = 2 THEN 1 ELSE 0 END) as two_stars')
            ->selectRaw('SUM(CASE WHEN stars = 1 THEN 1 ELSE 0 END) as one_star')
            ->selectRaw('SUM(CASE WHEN stars = 0 THEN 1 ELSE 0 END) as zero_stars')
            ->groupBy('level_number')
            ->orderBy('level_number', 'asc')
            ->get();

        // Prepare data for Chart.js
        $challengeNames = $progressData->pluck('level_number')->toArray();
        $progressValues = $progressData->pluck('avg_stars')->toArray();
        $threeStars = $progressData->pluck('three_stars')->toArray();
        $twoStars = $progressData->pluck('two_stars')->toArray();
        $oneStars = $progressData->pluck('one_star')->toArray();
        $zeroStars = $progressData->pluck('zero_stars')->toArray();

        return view('admin.index', [
            'adminCount' => User::where('role', 'admin')->count(),
            'educatorCount' => User::where('role', 'educator')->count(),
            'playerCount' => User::where('role', 'player')->count(),
            'totalUsers' => User::count(),
            'challengeNames' => $challengeNames,
            'progressValues' => $progressValues,
            'threeStars' => $threeStars,
            'twoStars' => $twoStars,
            'oneStars' => $oneStars,
            'zeroStars' => $zeroStars,
        ]);
    }



    public function index()
    {
        // Fetch only users with the role 'admin'
        $admins = User::where('role', 'admin')->get();
        return view('admin.admin', compact('admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'email' => $request->email,
            'role' => 'admin', // Default role is 'admin'
            'password' => Hash::make($request->password), // Securely hash the password
        ]);

        return response()->json(['success' => true, 'message' => 'Admin added successfully!']);
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $id, // Allow existing email
        'role' => 'required|in:admin,player,educator', // Validate role
        'password' => 'nullable|min:6', // Password is optional but must be at least 6 chars if provided
    ]);

    $admin = User::findOrFail($id); // Find the admin by ID

    // Update fields
    $admin->email = $request->email;
    $admin->role = $request->role;

    // Only update password if a new one is provided
    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    $admin->save(); // Save changes

    return response()->json(['success' => true, 'message' => 'Admin updated successfully!']);
}

public function destroy($id)
{
    $admin = User::findOrFail($id);
    $admin->delete();

    return response()->json(['success' => true, 'message' => 'Admin deleted successfully!']);
}
}
