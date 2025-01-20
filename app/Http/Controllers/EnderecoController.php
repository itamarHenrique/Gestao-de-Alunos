<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoPostRequest;
use App\Http\Requests\EnderecoUpdateRequest;
use App\Models\Endereco;
use App\Services\EnderecoService;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    private $enderecoService;

    public function __construct(EnderecoService $enderecoService)
    {
        $this->enderecoService = $enderecoService;
    }


    public function index()
    {
        $endereco = $this->enderecoService->getAll();

        return $endereco;
    }

    public function getById($id)
    {
        $endereco = $this->enderecoService->getById($id);

        return $endereco;
    }

    public function createEndereco(EnderecoPostRequest $request)
    {
        $data = $request->validated();

        $endereco = $this->enderecoService->createEndereco($data);

        if(!$endereco){
            return response()->json(['message' => 'Erro ao criar endereço'], 400);
        }

        return $endereco;
    }

    public function updateEndereco(EnderecoUpdateRequest $request, $id)
{
    $data = $request->validated();

    try {
        $endereco = $this->enderecoService->updateEndereco($data, $id);

        if (!$endereco) {
            return response()->json(['message' => 'Erro ao atualizar endereço'], 400);
        }

        return response()->json($endereco, 200);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 400);
    }
}



}
