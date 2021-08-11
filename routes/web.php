<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
route::get('/Tarefa', function(){
    return view('auth.welcome');
});
route::get('/Perfil', function(){
    return view('auth.welcome');
});
route::get('/Signup', function(){
    return view('auth.welcome');
});

