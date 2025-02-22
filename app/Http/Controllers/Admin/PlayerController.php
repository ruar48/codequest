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
