<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Curso;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $alunos = Aluno::latest()->take(10)->get();

        $alunos->load('cursos', 'enderecos');

        $totalAlunos = $alunos->count();
        $totalCursos = Curso::count();

        return view('admin.dashboard', compact('alunos', 'totalAlunos', 'totalCursos'));
    }
}
