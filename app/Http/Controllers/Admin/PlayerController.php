<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    public function index()
    {
        $players = User::where('role', 'player')->get();
        return view('admin.player', compact('players'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'player',
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $player = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$player->id,
            'password' => 'nullable|min:6',
        ]);

        $player->email = $request->email;
        if ($request->password) {
            $player->password = Hash::make($request->password);
        }
        $player->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $player = User::findOrFail($id);
        $player->delete();

        return response()->json(['success' => true]);
    }
}
