<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PlayerController extends Controller
{
    public function index()
        {
            $players = User::where('role', 'player')->get();
            return view('admin.player', compact('players'));
        }

}
public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    User::create([
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'player',
    ]);

    return response()->json(['message' => 'Player added successfully']);
}
public function update(Request $request, $id)
{
    $player = User::findOrFail($id);

    $request->validate([
        'email' => 'required|email|unique:users,email,' . $player->id,
    ]);

    $player->email = $request->email;

    if ($request->filled('password')) {
        $player->password = bcrypt($request->password);
    }

    $player->save();

    return response()->json(['message' => 'Player updated successfully']);
}
public function destroy($id)
{
    $player = User::findOrFail($id);
    $player->delete();

    return response()->json(['message' => 'Player deleted successfully']);
}
