<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Primeiro tenta autenticar como usuário (admin ou outro)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->perfil === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        // Se falhar, tenta autenticar como aluno
        $aluno = Aluno::where('email', $credentials['email'])->first();

        if ($aluno && Hash::check($credentials['password'], $aluno->password)) {
            Auth::guard('aluno')->login($aluno);
            $request->session()->regenerate();
            return redirect()->route('aluno.dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais estão incorretas.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('aluno')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function dashboard()
    {
        $usuario = Auth::guard('aluno')->check()
            ? Auth::guard('aluno')->user()
            : Auth::user();

        return view('user.dashboard', compact('usuario'));
    }


}