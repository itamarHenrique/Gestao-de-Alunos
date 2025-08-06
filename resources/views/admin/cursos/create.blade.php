@extends('layouts.admin-navbar')

@section('title', 'Criar Curso')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-semibold mb-6">Criar Novo Curso</h1>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.cursos.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nome" class="block text-gray-700 mb-2">Nome do Curso</label>
            <input type="text" id="nome" name="nome" 
                value="{{ old('nome') }}" 
                class="w-full border border-gray-300 rounded px-3 py-2 @error('nome') border-red-500 @enderror" 
                placeholder="Digite o nome do curso">
            @error('nome')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="formacao" class="block text-gray-700 mb-2">Tipo de Formação</label>
            <select name="formacao" id="formacao"
                class="w-full border border-gray-300 rounded px-3 py-2 @error('formacao') border-red-500 @enderror">
                <option value="">Selecione...</option>
                @foreach(config('constants.tipo_formacao', []) as $opcao)
                    <option value="{{ $opcao }}" {{ old('formacao') == $opcao ? 'selected' : '' }}>
                        {{ $opcao }}
                    </option>
                @endforeach
            </select>
            @error('formacao')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.cursos.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voltar</a>

            <button type="submit" 
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Criar Curso</button>
        </div>
    </form>
</div>
@endsection
