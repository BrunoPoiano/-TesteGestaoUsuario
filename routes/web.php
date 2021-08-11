<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'signup'])->name('register');
route::get('/Tarefa', function(){
    return view('auth.welcome');
});
route::get('/UserCrud', function(){
    return view('auth.welcome');
});
route::get('/Signup', function(){
    return view('auth.welcome');
});
Route::middleware('auth:sanctum')->get('/dashboard', [AuthController::class, 'dashboardView'])->name('dashboard');

Route::get('/user', [AuthController::class, 'user'])->name('user');
