<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EducatorController extends Controller
{
    public function index()
    {
        $educators = User::where('role', 'educator')->get();
        return view('admin.educators', compact('educators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'email' => $request->email,
            'role' => 'educator', // Default role as educator
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['success' => true, 'message' => 'Educator added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'password' => 'nullable|min:6',
        ]);

        $educator = User::findOrFail($id);
        $educator->email = $request->email;
        $educator->role = $request->role;

        if ($request->password) {
            $educator->password = Hash::make($request->password);
        }

        $educator->save();

        return response()->json(['success' => true, 'message' => 'Educator updated successfully!']);
    }

    public function destroy($id)
{
    $educator = User::findOrFail($id);
    $educator->delete();

    return response()->json(['success' => true, 'message' => 'Educator deleted successfully!']);
}

}
