@extends('layouts.admin-navbar')

@section('title', 'Criar Aluno')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-semibold mb-6">Criar Aluno</h1>

    
    @if ($errors->any())
        <div class="mb-6 bg-red-100 text-red-700 p-4 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.alunos.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium" for="primeiro_nome">Primeiro Nome</label>
                <input type="text" id="primeiro_nome" name="primeiro_nome" value="{{ old('primeiro_nome') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="sobrenome">Sobrenome</label>
                <input type="text" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="matricula">Matrícula</label>
                <input type="text" id="matricula" name="matricula" value="{{ old('matricula') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="user_status">Status do Usuário</label>
                <select id="user_status" name="user_status" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
                    @php
                        $statusOptions = config('constants.user_status');
                        $selectedStatus = old('user_status');
                    @endphp
                    @foreach ($statusOptions as $status)
                        <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium" for="celular">Celular</label>
                <input type="text" id="celular" name="celular" value="{{ old('celular') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="unidade_de_ensino">Unidade de Ensino</label>
                <input type="text" id="unidade_de_ensino" name="unidade_de_ensino" value="{{ old('unidade_de_ensino') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="password">Senha</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="password_confirmation">Confirmar Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <hr class="my-6">

        <h2 class="text-xl font-semibold mb-4">Endereço</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-1 font-medium" for="enderecos[rua]">Rua</label>
                <input type="text" id="enderecos[rua]" name="enderecos[rua]" value="{{ old('enderecos.rua') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="enderecos[numero_da_casa]">Número da Casa</label>
                <input type="text" id="enderecos[numero_da_casa]" name="enderecos[numero_da_casa]" value="{{ old('enderecos.numero_da_casa') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="enderecos[cep]">CEP</label>
                <input type="text" id="enderecos[cep]" name="enderecos[cep]" value="{{ old('enderecos.cep') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium" for="enderecos[bairro]">Bairro</label>
                <input type="text" id="enderecos[bairro]" name="enderecos[bairro]" value="{{ old('enderecos.bairro') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-4">Curso</h2>
        <select name="curso[nome]" class="w-full border border-gray-300 rounded px-3 py-2 mb-6" required>
            <option value="">Selecione um curso</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso->nome }}" {{ old('curso.nome') == $curso->nome ? 'selected' : '' }}>
                    {{ $curso->nome }}
                </option>
            @endforeach
        </select>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.alunos.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Criar</button>
        </div>
    </form>
</div>
@endsection
