<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

Route::post('/register', [AuthController::class, 'registerUser'])->name('register.post');

Route::post('/login', [AuthController::class, 'loginUser'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logoutUser'])->middleware('auth:sanctum')->name('logout');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', [AuthController::class, 'getUser'])->name('user'); // Only one definition

    Route::middleware('role:1')->get('/admin', function () {
        return response()->json(['message' => 'Admin Dashboard']);
    })->name('admin');

    Route::middleware('role:2')->get('/manager', function () {
        return response()->json(['message' => 'Manager Dashboard']);
    })->name('manager');

    Route::middleware('role:3')->get('/user-dashboard', function () {
        return response()->json(['message' => 'User Dashboard']);
    })->name('user');
});

Route::get('/api/test', function () {
    return response()->json(['message' => 'API is working!']);
});
