<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user registration and return a custom token.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'token' => Str::random(60),
        ]);

        return response()->json([
            'access_token' => $user->token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Handle user login and return a custom token.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Generate a new token
        $user->token = Str::random(60);
        $user->save();

        return response()->json([
            'access_token' => $user->token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Handle logout by deleting the user's current token.
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->token = null;
            $user->save();
        }

        return response()->json(['message' => 'Logged out']);
    }

    /**
     * Return the authenticated user's data.
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
