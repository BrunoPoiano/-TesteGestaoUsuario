<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tarefa\TarefaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
///////TAREFAS///////
Route::resource('tarefas', TarefaController::class);
Route::get('tarefasFinalizadas', [TarefaController::class, 'tarefasFinalizadas'])->name('tarefasFinalizadas');
Route::get('userTarefas', [TarefaController::class, 'userTarefas'])->name('userTarefas');
Route::get('prioridades', [TarefaController::class, 'prioridades'])->name('prioridades');


///////USUARIO///////
Route::get('/user', [AuthController::class, 'user'])->name('user');
//Autenticar usuario
Route::post('createSignin', [AuthController::class, 'createSignin'])->name('createSignin');
//Criar usuario
Route::post('customSignup', [AuthController::class, 'customSignup'])->name('customSignup');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::put('updateName', [AuthController::class, 'updateName'])->name('updateName');
Route::put('updateEmail', [AuthController::class, 'updateEmail'])->name('updateEmail');
Route::put('updatePassword', [AuthController::class, 'updatePassword'])->name('updatePassword');

