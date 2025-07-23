<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPerfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/CheckPerfil.php
    public function handle(Request $request, Closure $next, $perfil)
    {
        // Verifica usuários normais (web guard)
        if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()->perfil !== $perfil) {
                abort(403);
            }
        }
        // Verifica alunos (aluno guard)
        elseif (Auth::guard('aluno')->check()) {
            if ($perfil !== 'aluno') { // Perfil fixo para alunos
                abort(403);
            }
        }
        else {
            echo 'erro';
            return redirect()->route('login');
        }

        return $next($request);
    }
}