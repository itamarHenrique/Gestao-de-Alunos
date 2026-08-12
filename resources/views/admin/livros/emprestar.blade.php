@extends('layouts.admin-navbar')

@section('title', 'Emprestar Livro')

@section('content')
    <a href="{{ route('admin.livros.index') }}" 
       class="inline-block mb-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        ← Voltar aos Livros
    </a>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-semibold mb-2">Emprestar Livro</h1>

        <p class="text-gray-600 mb-4">
            <strong>{{ $livro->titulo }}</strong> — {{ $livro->autor }}
            <span class="ml-2 px-2 py-1 text-xs rounded-full {{ $livro->disponiveis > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $livro->disponiveis }} disponível(is)
            </span>
        </p>

        @if($livro->disponiveis <= 0)
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                Não há exemplares disponíveis para empréstimo.
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

        <form action="{{ route('admin.livros.emprestimos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="livro_id" value="{{ $livro->id }}">

            <div class="mb-4">
                <label for="aluno_id" class="block text-gray-700 mb-2">Aluno</label>
                <select name="aluno_id" id="aluno_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">Selecione um aluno...</option>
                    @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}" {{ old('aluno_id') == $aluno->id ? 'selected' : '' }}>
                            {{ $aluno->primeiro_nome }} {{ $aluno->sobrenome }} — {{ $aluno->matricula }}
                        </option>
                    @endforeach
                </select>
                @error('aluno_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('admin.livros.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>

                <button type="submit" 
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Confirmar Empréstimo</button>
            </div>
        </form>
    </div>
@endsection
