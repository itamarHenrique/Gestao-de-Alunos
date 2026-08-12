@extends('layouts.admin-navbar')

@section('title', 'Livros')

@section('content')
    <a href="{{ route('admin.dashboard') }}" 
       class="inline-block mb-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        ← Voltar ao Dashboard
    </a>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-6">Biblioteca</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Título</th>
                <th class="py-2 px-4 border-b">Autor</th>
                <th class="py-2 px-4 border-b">Editora</th>
                <th class="py-2 px-4 border-b text-center">Disponíveis</th>
                <th class="py-2 px-4 border-b text-center" colspan="4">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($livros as $livro)
                <tr>
                    <td class="border px-4 py-2">{{ $livro->titulo }}</td>
                    <td class="border px-4 py-2">{{ $livro->autor }}</td>
                    <td class="border px-4 py-2">{{ $livro->editora ?? '---' }}</td>
                    <td class="border px-4 py-2 text-center">
                        <span class="px-2 py-1 text-xs rounded-full {{ $livro->disponiveis > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $livro->disponiveis }}/{{ $livro->quantidade }}
                        </span>
                    </td>

                    <!-- Emprestar -->
                    <td class="border px-4 py-2 text-center">
                        <a href="{{ route('admin.livros.emprestar', $livro->id) }}"
                           class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-full inline-flex items-center"
                           title="Emprestar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a4 4 0 00-8 0v2M5 11h14v10H5V11z" />
                            </svg>
                        </a>
                    </td>

                    <!-- Botão Editar -->
                    <td class="border px-4 py-2 text-center">
                        <a href="{{ route('admin.livros.edit', $livro->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full inline-flex items-center"
                           title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5
                                      M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </a>
                    </td>

                    <!-- Botão Excluir -->
                    <td class="border px-4 py-2 text-center">
                        <form action="{{ route('admin.livros.destroy', $livro->id) }}" method="POST"
                              onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full inline-flex items-center"
                                    title="Excluir">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                                          m5-3h4a1 1 0 011 1v1H9V5a1 1 0 011-1zm-3 4h10" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Nenhum livro cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Área de Paginação + botões -->
    <div class="flex justify-between items-center mt-4">
        <div class="space-x-2">
            <a href="{{ route('admin.livros.create') }}" 
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
               Cadastrar Livro
            </a>
            <a href="{{ route('admin.livros.emprestimos') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               Empréstimos Ativos
            </a>
        </div>

        <!-- Paginação -->
        <div>
            {{ $livros->links() }}
        </div>
    </div>
@endsection
