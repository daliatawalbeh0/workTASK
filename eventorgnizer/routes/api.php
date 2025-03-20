<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// مسارات التسجيل
Route::post('/register', [AuthController::class, 'registerUser'])->name('register.post');

// مسارات تسجيل الدخول
Route::post('/login', [AuthController::class, 'loginUser'])->name('login.post');

// مسار تسجيل الخروج
Route::post('/logout', [AuthController::class, 'logoutUser'])->middleware('auth:sanctum')->name('logout');

// مسارات المحميّة باستخدام التوثيق
Route::middleware(['auth:sanctum'])->group(function () {

    // جلب بيانات المستخدم الحالي
    Route::get('/user', [AuthController::class, 'getUser'])->name('user');

    // مسار خاص بالمشرف
    Route::middleware('role:1')->get('/admin', function () {
        return response()->json(['message' => 'Admin Dashboard']);
    })->name('admin');

    // مسار خاص بالمدير
    Route::middleware('role:2')->get('/manager', function () {
        return response()->json(['message' => 'Manager Dashboard']);
    })->name('manager');

    // مسشار خاص بالمستخدم
    Route::middleware('role:3')->get('/user-dashboard', function () {
        return response()->json(['message' => 'User Dashboard']);
    })->name('user');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api/test', function () {
    return response()->json(['message' => 'API is working!']);
});
