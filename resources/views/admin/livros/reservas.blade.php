@extends('layouts.admin-navbar')

@section('title', 'Reservas Pendentes')

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

    <h1 class="text-3xl font-bold mb-2">Reservas Pendentes</h1>
    <p class="text-gray-600 mb-6">Acordos de retirada firmados pelos alunos. Confirme quando o aluno chegar para retirar o livro.</p>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Aluno</th>
                <th class="py-2 px-4 border-b">Livro</th>
                <th class="py-2 px-4 border-b">Data de Retirada</th>
                <th class="py-2 px-4 border-b text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $reserva)
                <tr>
                    <td class="border px-4 py-2">{{ $reserva->aluno_nome }}</td>
                    <td class="border px-4 py-2">{{ $reserva->livro_titulo }}</td>
                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($reserva->data_retirada)->format('d/m/Y') }}</td>
                    <td class="border px-4 py-2 text-center">
                        <div class="flex justify-center space-x-2">
                            <form action="{{ route('admin.livros.reservas.confirmar', $reserva->id) }}" method="POST"
                                  onsubmit="return confirm('Confirmar retirada? O empréstimo será registrado para o aluno.');">
                                @csrf
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                    Confirmar retirada
                                </button>
                            </form>

                            <form action="{{ route('admin.livros.reservas.cancelar', $reserva->id) }}" method="POST"
                                  onsubmit="return confirm('Cancelar esta reserva?');">
                                @csrf
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                    Cancelar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Nenhuma reserva pendente.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $reservas->links() }}
    </div>
@endsection
