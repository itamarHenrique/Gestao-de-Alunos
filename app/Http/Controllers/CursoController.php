<?php

namespace App\Http\Controllers;

use App\Services\CursoService;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    private $cursoService;

    public function __construct(CursoService $cursoService)
    {
        $this ->cursoService = $cursoService;
    }

    public function getAll()
    {
        return $this->cursoService->getAll();
    }

    public function getById($id)
    {
        return $this->cursoService->getById($id);

    }
}
