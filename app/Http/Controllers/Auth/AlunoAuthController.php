<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunoAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(['email' => 'required|email','password' => 'required']);

        if(Auth::guard('aluno')->attempt($credentials, $request->remember)){
            $request->session()->regenerate();

            return redirect()->intended('user.dashboard');
        }

        return back()->withErrors(['email'=> 'Credenciais invalidas'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('aluno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
