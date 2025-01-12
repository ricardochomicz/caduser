<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function authForm()
    {
        return view('auth.auth');
    }

    public function login(Request $request)
    {
        //Validação dos dados
        $validator = Validator::make($request->all(), [
            'lemail' => 'required|email',
            'lpassword' => 'required|min:6',
        ], [
            'lemail.required' => 'O campo e-mail é obrigatório',
            'lemail.email' => 'Por favor, insira um endereço de e-mail válido.',
            'lpassword.required' => 'O campo senha é obrigatório.',
            'lpassword.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Credenciais para autenticação 
        $credentials = [
            'email' => $request->input('lemail'),
            'password' => $request->input('lpassword')
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/app/users');
        } else {
            flash()->option('position', 'bottom-right')
                ->error('Credenciais inválidas, tente novamente.');
            return redirect()->back();
        }
    }



    public function register(Request $request)
    {
        //Validação dos dados
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de e-mail válido.',
            'email.unique' => 'Este endereço de e-mail já está registrado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cria o usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Autentica o usuário
        Auth::login($user);

        // Redirecionar após o registro 
        return redirect('/app/users');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
