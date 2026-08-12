@extends('layouts.admin-navbar')

@section('title', 'Editar Livro')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-semibold mb-6">Editar Livro</h1>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.livros.update', $livro->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="titulo" class="block text-gray-700 mb-2">Título *</label>
            <input type="text" id="titulo" name="titulo" 
                value="{{ old('titulo', $livro->titulo) }}" 
                class="w-full border border-gray-300 rounded px-3 py-2 @error('titulo') border-red-500 @enderror">
            @error('titulo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="autor" class="block text-gray-700 mb-2">Autor *</label>
            <input type="text" id="autor" name="autor" 
                value="{{ old('autor', $livro->autor) }}" 
                class="w-full border border-gray-300 rounded px-3 py-2 @error('autor') border-red-500 @enderror">
            @error('autor')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="mb-4">
                <label for="editora" class="block text-gray-700 mb-2">Editora</label>
                <input type="text" id="editora" name="editora" 
                    value="{{ old('editora', $livro->editora) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="ano" class="block text-gray-700 mb-2">Ano</label>
                <input type="number" id="ano" name="ano" min="1800" max="{{ date('Y') }}"
                    value="{{ old('ano', $livro->ano) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="quantidade" class="block text-gray-700 mb-2">Quantidade</label>
                <input type="number" id="quantidade" name="quantidade" min="1"
                    value="{{ old('quantidade', $livro->quantidade) }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <div class="mb-4">
            <label for="categoria" class="block text-gray-700 mb-2">Categoria</label>
            <input type="text" id="categoria" name="categoria" 
                value="{{ old('categoria', $livro->categoria) }}" 
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label for="descricao" class="block text-gray-700 mb-2">Descrição</label>
            <textarea id="descricao" name="descricao" rows="4"
                class="w-full border border-gray-300 rounded px-3 py-2">{{ old('descricao', $livro->descricao) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="arquivo_pdf" class="block text-gray-700 mb-2">Arquivo PDF (máx. 20MB)</label>
            @if($livro->arquivo_pdf)
                <p class="text-sm text-gray-600 mb-2">Arquivo atual: {{ basename($livro->arquivo_pdf) }}</p>
            @endif
            <input type="file" id="arquivo_pdf" name="arquivo_pdf" accept="application/pdf"
                class="w-full border border-gray-300 rounded px-3 py-2 @error('arquivo_pdf') border-red-500 @enderror">
            @error('arquivo_pdf')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.livros.index') }}" 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voltar</a>

            <button type="submit" 
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Atualizar</button>
        </div>
    </form>
</div>
@endsection
