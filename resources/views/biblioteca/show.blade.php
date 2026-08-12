@extends('layouts.user-navbar')

@section('title', $livro->titulo)

@section('content')
    <a href="{{ route('biblioteca.index') }}" 
       class="inline-block mb-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        ← Voltar ao Catálogo
    </a>

    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex-shrink-0">
                <div class="bg-green-50 w-40 h-56 rounded-lg shadow-inner flex items-center justify-center">
                    <span class="material-icons text-green-600 text-6xl">menu_book</span>
                </div>
            </div>

            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800">{{ $livro->titulo }}</h1>
                <p class="text-gray-600 mt-1 text-lg">por {{ $livro->autor }}</p>

                <div class="flex flex-wrap gap-2 mt-4">
                    @if($livro->editora)
                        <span class="bg-gray-100 px-3 py-1 rounded text-sm text-gray-600">Editora: {{ $livro->editora }}</span>
                    @endif
                    @if($livro->ano)
                        <span class="bg-gray-100 px-3 py-1 rounded text-sm text-gray-600">Ano: {{ $livro->ano }}</span>
                    @endif
                    @if($livro->categoria)
                        <span class="bg-gray-100 px-3 py-1 rounded text-sm text-gray-600">Categoria: {{ $livro->categoria }}</span>
                    @endif
                </div>

                <div class="mt-4">
                    <span class="px-3 py-1 rounded-full text-sm {{ $livro->disponiveis > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $livro->disponiveis > 0 ? $livro->disponiveis . ' exemplar(es) disponível(is) de ' . $livro->quantidade : 'Indisponível no momento' }}
                    </span>
                </div>

                @if($livro->descricao)
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">Sinopse</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $livro->descricao }}</p>
                    </div>
                @endif

                <div class="mt-8 space-x-3">
                    @if($livro->arquivo_pdf)
                        <a href="{{ route('biblioteca.download', $livro->id) }}"
                           class="inline-flex items-center bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            <span class="material-icons text-sm mr-2">download</span>
                            Baixar PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
