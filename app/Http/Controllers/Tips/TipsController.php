<?php

namespace App\Http\Controllers\Tips;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tips;

class TipsController extends Controller
{
    public function tips()
    {
        $tips = Tips::all(); // Fetch all tips from the database
        return view('admin.tips', compact('tips'));

    }



    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $tip = Tips::create([
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tip added successfully!',
            'tip' => $tip
        ]);
    }

    public function TipsFetch()
    {
        $tips = Tips::pluck('description')->toArray(); // Fetch tips as a simple array
        shuffle($tips); // Randomize the order of tips

        return response()->json([
            'tips' => $tips
        ]);
    }



}
