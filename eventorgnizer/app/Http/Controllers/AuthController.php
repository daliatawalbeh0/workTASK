<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Registration()
    {
        return view('auth.register-user');
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 3, // تأكد من أن 3 هو الدور الافتراضي الصحيح
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Welcome ' . $data['name'] . ', you registered successfully!');
    }

    public function loginUser(Request $request)
    {
        // Validate the credentials
        $credentials = $request->only('email', 'password');
    
        // Check if the credentials are valid
        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();
    
            // Create a token for the user
            $token = $user->createToken('YourAppName')->plainTextToken;
    
            // Return the token and user data as a JSON response
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }
    
        // If authentication fails, return a 401 response
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    
    

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->flush(); // تنظيف الجلسة بالكامل
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully!');
    }
}
