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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return match ($user->role_id) {
                1 => redirect()->route('admin')->with('success', 'Welcome ' . $user->name . '!'),
                2 => redirect()->route('manager')->with('success', 'Welcome ' . $user->name . '!'),
                3 => redirect()->route('user')->with('success', 'Welcome ' . $user->name . '!'),
                default => redirect()->route('dashboard')->with('success', 'Welcome ' . $user->name . '!'),
            };
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->flush(); // تنظيف الجلسة بالكامل
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully!');
    }
}
