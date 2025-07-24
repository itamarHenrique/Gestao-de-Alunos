@extends('layouts.admin-navbar')

@section('title', 'Editar Aluno')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow mt-6">
    <h1 class="text-3xl font-semibold mb-6">Editar Aluno</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.alunos.update', $aluno->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             
            <div>
                <label class="block mb-1 font-medium text-gray-700">Primeiro Nome</label>
                <input type="text" name="primeiro_nome" value="{{ old('primeiro_nome', $aluno->primeiro_nome) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Sobrenome</label>
                <input type="text" name="sobrenome" value="{{ old('sobrenome', $aluno->sobrenome) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Matrícula</label>
                <input type="text" name="matricula" value="{{ old('matricula', $aluno->matricula) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $aluno->email) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">Status do Usuário</label>
                <select name="user_status" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    @foreach(config('constants.user_status') as $status)
                        <option value="{{ $status }}" {{ old('user_status', $aluno->user_status) == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Celular</label>
                <input type="text" name="celular" value="{{ old('celular', $aluno->celular) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700">Unidade de Ensino</label>
                <input type="text" name="unidade_de_ensino" value="{{ old('unidade_de_ensino', $aluno->unidade_de_ensino) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium text-gray-700">Curso</label>
                <select name="curso[nome]" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->nome }}" {{ (old('curso.nome', $aluno->cursos->pluck('nome')->first() ?? '') == $curso->nome) ? 'selected' : '' }}>
                            {{ $curso->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Rua</label>
                <input type="text" name="enderecos[rua]" value="{{ old('enderecos.rua', $aluno->enderecos->pluck('rua')->first() ?? '') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700">Número da Casa</label>
                <input type="text" name="enderecos[numero_da_casa]" value="{{ old('enderecos.numero_da_casa', $aluno->enderecos->pluck('numero_da_casa')->first() ?? '') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            
            <div>
                <label class="block mb-1 font-medium text-gray-700">CEP</label>
                <input type="text" name="enderecos[cep]" value="{{ old('enderecos.cep', $aluno->enderecos->pluck('cep')->first() ?? '') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            
            <div>
                <label class="block mb-1 font-medium text-gray-700">Bairro</label>
                <input type="text" name="enderecos[bairro]" value="{{ old('enderecos.bairro', $aluno->enderecos->pluck('bairro')->first() ?? '') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.alunos.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Voltar
            </a>

            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Atualizar
            </button>
        </div>
    </form>
</div>
@endsection
