@extends('layouts.admin-navbar')

@section('title', 'Empréstimos Ativos')

@section('content')
    <a href="{{ route('admin.livros.index') }}" 
       class="inline-block mb-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        ← Voltar aos Livros
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

    <h1 class="text-3xl font-bold mb-6">Empréstimos Ativos</h1>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Aluno</th>
                <th class="py-2 px-4 border-b">Livro</th>
                <th class="py-2 px-4 border-b">Data do Empréstimo</th>
                <th class="py-2 px-4 border-b text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($emprestimos as $emprestimo)
                <tr>
                    <td class="border px-4 py-2">{{ $emprestimo->aluno_nome }}</td>
                    <td class="border px-4 py-2">{{ $emprestimo->livro_titulo }}</td>
                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($emprestimo->data_emprestimo)->format('d/m/Y') }}</td>
                    <td class="border px-4 py-2 text-center">
                        <form action="{{ route('admin.livros.emprestimos.devolver', $emprestimo->id) }}" method="POST"
                              onsubmit="return confirm('Confirmar devolução do livro?');">
                            @csrf
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                                    title="Devolver">
                                Devolver
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Nenhum empréstimo ativo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $emprestimos->links() }}
    </div>
@endsection
