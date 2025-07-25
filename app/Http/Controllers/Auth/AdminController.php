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
        $alunos = Aluno::with('cursos', 'enderecos')->latest()->paginate(10);

        // $alunos->load('cursos', 'enderecos');

        $totalAlunos = Aluno::count();
        $totalCursos = Curso::count();

        return view('admin.dashboard', compact('alunos', 'totalAlunos', 'totalCursos'));
    }
}
