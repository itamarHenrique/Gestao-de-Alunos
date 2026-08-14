@extends('layouts.user-navbar')

@section('title', 'Meus Empréstimos')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Meus Empréstimos</h1>
        <p class="text-gray-600 mt-1">Histórico de empréstimos de livros.</p>
    </div>

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

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Livro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data do Empréstimo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Devolução</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($emprestimos as $emprestimo)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $emprestimo->titulo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($emprestimo->pivot->data_emprestimo)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $emprestimo->pivot->data_devolucao ? \Carbon\Carbon::parse($emprestimo->pivot->data_devolucao)->format('d/m/Y') : '---' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($emprestimo->pivot->data_devolucao)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Devolvido</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Emprestado</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Você ainda não possui empréstimos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Minhas Reservas</h2>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Livro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data de Retirada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ação</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservas as $reserva)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $reserva->livro->titulo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $reserva->data_retirada->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reserva->status == \App\Models\Reserva::STATUS_PENDENTE)
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pendente</span>
                                @elseif($reserva->status == \App\Models\Reserva::STATUS_CONFIRMADA)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Retirado</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full">Cancelada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reserva->status == \App\Models\Reserva::STATUS_PENDENTE)
                                    <form action="{{ route('biblioteca.reservas.cancelar', $reserva->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs"
                                                onclick="return confirm('Cancelar esta reserva?');">
                                            Cancelar
                                        </button>
                                    </form>
                                @else
                                    ---
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                Você ainda não possui reservas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
