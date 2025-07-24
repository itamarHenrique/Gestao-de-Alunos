@extends('layouts.admin-navbar')

@section('title', 'Alunos')

@section('content')
    <a href="{{ route('admin.dashboard') }}" 
    class="inline-block mb-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        ← Voltar ao Dashboard
    </a>

    <h1 class="text-3xl font-bold mb-6">Lista de Alunos</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nome</th>
                <th class="py-2 px-4 border-b">Matrícula</th>
                <th class="py-2 px-4 border-b">Curso</th>
                <th class="py-2 px-4 border-b">Data</th>
                <th class="py-2 px-4 border-b">Ações</th> <!-- nova coluna para botões -->
            </tr>
        </thead>
        <tbody>
        @forelse($alunos as $aluno)
        <tr>
            <td class="border px-4 py-2">{{ $aluno->primeiro_nome . ' ' . $aluno->sobrenome }}</td>
            <td class="border px-4 py-2">{{ $aluno->matricula }}</td>
            <td class="border px-4 py-2">{{ $aluno->cursos->pluck('nome')->first() ?? '---' }}</td>
            <td class="border px-4 py-2">{{ $aluno->created_at->format('d/m/Y') }}</td>
            <td class="border px-4 py-2 text-center">
                <a href="{{ route('admin.alunos.edit', $aluno->id) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full inline-flex items-center"
                title="Editar">
                    <!-- Ícone de lápis (editar) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </a>
            </td>
            <td class="border px-4 py-2 text-center">
                <form action="{{ route('admin.alunos.delete', $aluno->id) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full inline-flex items-center"
                            title="Excluir">
                        <!-- Ícone de lixeira -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4a1 1 0 011 1v1H9V5a1 1 0 011-1zm-3 4h10" />
                        </svg>
                    </button>
                </form>
            </td>
        </tr>
    @empty

                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Nenhum aluno encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Área de Paginação + botão criar novo -->
    <div class="flex justify-between items-center mt-4">
        <a href="{{ route('admin.alunos.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
           Criar Novo Aluno
        </a>

        <!-- Paginação -->
        <div>
            {{ $alunos->links() }}
        </div>
    </div>
@endsection
