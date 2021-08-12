<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Mail\User\CriacaoPerfil;
use App\Mail\User\DeletarPerfil;
use App\Mail\User\UpdatePerfil;
use App\Models\Tarefa\Tarefa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.welcome');
    }

    public function user()
    {
        return Auth::user();
    }

    public function createSignin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->get()->first();
        if (Hash::check($request->password, $user->password)) {

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {

                //JWT token
                $jwtToken = Auth::user()->createToken($request->email)->plainTextToken;

                //Create Cookie to store the token
                $cookie = cookie($name = 'jwt', $value = $jwtToken, $minutes = 60 * 24); // 1dia

                return response([
                    'message' => 'Success',
                ])->withCookie($cookie);
            }
        }
        return response(['message' => 'Usuario não existe'], 404);
    }

    public function customSignup(UserRequest $request)
    {
        //Salvando novo Usuario
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        //Enviando email de confirmação de criacão de perfil
        Mail::to($request->email)->send(new CriacaoPerfil());

        return response([
            'message' => 'Usuario Criado com Sucesso',
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            $cookie = cookie::forget('jwt');
            Session::flush();
            Auth::logout();
            return response([
                'message' => 'User Logout',
            ])->withCookie($cookie);
        }
        return response(['message' => 'Erro'], 404);

    }

    public function destroy()
    {
        if (Auth::check()) {

            $user = User::find(Auth::id());
            if ($user) {

                //Apagando Tarefas do  Usuario
                $userTarefas = Tarefa::where('user_id', Auth::id())->get();
                for ($i = 0; $i < count($userTarefas); $i++) {
                    $userTarefas[$i]->delete();
                }
                //Enviando email de confirmação de Atualização de Nome
                Mail::to($user->email)->send(new DeletarPerfil());
                $cookie = cookie::forget('jwt');
                Session::flush();
                Auth::logout();

                $user->delete();
                return response([
                    'message' => 'User Deletado',
                ])->withCookie($cookie);
            }
            return response(['message' => 'Erro ao procurar usuario'], 404);

        }
        return response(['message' => 'Erro'], 404);

    }

    public function updateName(Request $request)
    {

        if ($request) {
            $request->validate([
                'name' => 'required',
            ]);
            $updUserName = User::find(Auth::id());
            $updUserName->name = $request->name;
            if ($updUserName->update()) {
                //Enviando email de confirmação de Atualização de Nome
                Mail::to($updUserName->email)->send(new UpdatePerfil());
                return response([
                    'message' => 'Nome Atualizado com Sucesso',
                ]);
            }
            return response([
                'message' => 'Erro Atualizar nome',
            ]);
        }
        return response([
            'message' => 'Erro ao receber data',
        ]);
    }

    public function updateEmail(Request $request)
    {
        if ($request) {
            $request->validate([
                'email' => 'required',
            ]);

            $updUserEmail = User::find(Auth::id());
            $updUserEmail->email = $request->email;

            if ($updUserEmail->update()) {
                //Enviando email de confirmação de Atualização de email
                Mail::to($updUserEmail->email)->send(new UpdatePerfil());

                return response([
                    'message' => 'Email Atualizado com sucesso',
                ]);
            }
            return response([
                'message' => 'Erro ao atualizar email',
            ]);
        }
        return response([
            'message' => 'Erro ao receber data',
        ]);
    }

    public function updatePassword(Request $request)
    {

        if ($request) {
            $request->validate([
                'senhaAntiga' => 'required',
                'senhaAntiga' => 'required',
            ]);
            $updUserPassword = User::find(Auth::id());
            if (Hash::check($request->senhaAntiga, $updUserPassword->password)) {
                $updUserPassword->password = Hash::make($request->novaSenha);
                $updUserPassword->update();
                //Enviando email de confirmação de Atualização de email
                Mail::to($updUserPassword->email)->send(new UpdatePerfil());
                return response([
                    'message' => 'senha atualizada com sucesso',
                ]);
            }
            return response([
                'message' => 'Senhas diferentes',
            ]);
        }
        return response([
            'message' => 'Erro ao receber data',
        ]);
    }

}
