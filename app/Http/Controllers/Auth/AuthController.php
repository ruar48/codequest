<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            // Check if the email already exists and return a custom message
            if ($validator->errors()->has('email')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already exists.'  // Custom error message for duplicate email
                ], 400);
            }

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first() // For other validation errors
            ], 400);
        }

        // Create the user with the default role 'player'
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'player', // Default role assigned
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.' // Success message
        ]);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Check if user exists with the given email
        $user = User::where('email', $request->email)->first();

        // Validate user and role
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        // Ensure the user is a 'player'
        if ($user->role !== 'player') {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Only players can log in here.',
            ], 403);
        }

        // Generate a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token' => $token, // Return token for authentication
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }



}
