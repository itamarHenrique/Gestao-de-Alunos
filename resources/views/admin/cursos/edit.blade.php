@extends('layouts.admin-navbar')

@section('title', 'Editar Curso')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-semibold mb-6">Editar Curso</h1>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.cursos.update', $curso->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nome" class="block text-gray-700 mb-2">Nome do Curso</label>
            <input type="text" id="nome" name="nome" 
                value="{{ old('nome', $curso->nome) }}" 
                class="w-full border border-gray-300 rounded px-3 py-2 @error('nome') border-red-500 @enderror">
            @error('nome')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.cursos.index') }}" 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voltar</a>

            <button type="submit" 
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Atualizar</button>
        </div>
    </form>
</div>
@endsection
