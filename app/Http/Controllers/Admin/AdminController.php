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
    $userProgress = Level::with('user')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($level) {
            return [
                'user_name'   => $level->user ? $level->user->full_name : 'Unknown User',
                'email'       => $level->user ? $level->user->email : 'N/A',
                'level_number'=> $level->level_number,
                'stars'       => $level->stars,
                'points'      => $level->points,
                'created_at'  => $level->created_at->diffForHumans(),
            ];
        });

    return view('admin.index', [
        'adminCount' => User::where('role', 'admin')->count(),
        'educatorCount' => User::where('role', 'educator')->count(),
        'playerCount' => User::where('role', 'player')->count(),
        'totalUsers' => User::count(),
        'userProgress' => $userProgress,
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
