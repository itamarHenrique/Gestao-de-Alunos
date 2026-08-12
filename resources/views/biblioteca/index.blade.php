@extends('layouts.user-navbar')

@section('title', 'Biblioteca Digital')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Biblioteca Digital</h1>
        <p class="text-gray-600 mt-1">Consulte os livros disponíveis na instituição.</p>
    </div>

    <!-- Busca -->
    <form action="{{ route('biblioteca.index') }}" method="GET" class="mb-8">
        <div class="flex gap-2 max-w-2xl">
            <input type="text" name="busca" value="{{ $termo }}"
                placeholder="Buscar por título, autor ou categoria..."
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            <button type="submit"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Buscar
            </button>
        </div>
    </form>

    @if($termo)
        <p class="text-gray-600 mb-4">Resultados para "<strong>{{ $termo }}</strong>"</p>
    @endif

    <!-- Grid de Livros -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($livros as $livro)
            <a href="{{ route('biblioteca.show', $livro->id) }}"
               class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center justify-between mb-3">
                    <span class="material-icons text-green-600 text-4xl">book</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $livro->disponiveis > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $livro->disponiveis > 0 ? $livro->disponiveis . ' disponível(is)' : 'Indisponível' }}
                    </span>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">{{ $livro->titulo }}</h3>
                <p class="text-gray-600 text-sm">{{ $livro->autor }}</p>
                @if($livro->categoria)
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="bg-gray-100 px-2 py-1 rounded">{{ $livro->categoria }}</span>
                    </p>
                @endif
            </a>
        @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                Nenhum livro encontrado.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $livros->links() }}
    </div>
@endsection
