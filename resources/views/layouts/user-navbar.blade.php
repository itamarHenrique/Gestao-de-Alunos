<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Biblioteca')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-sans">

    @php
        $usuario = Auth::guard('aluno')->check() ? Auth::guard('aluno')->user() : Auth::user();
    @endphp

    <!-- Barra de Navegação -->
    <nav class="bg-green-700 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="material-icons">menu_book</span>
                <a href="{{ route('biblioteca.index') }}" class="font-semibold hover:text-green-200">Biblioteca Digital</a>
            </div>
            <div class="flex items-center space-x-4">
                @if($usuario)
                    <span class="text-sm">Olá, {{ $usuario->primeiro_nome ?? $usuario->name }}</span>
                    <a href="{{ $usuario instanceof \App\Models\Aluno ? route('aluno.dashboard') : route('user.dashboard') }}"
                       class="flex items-center space-x-1 hover:bg-green-600 px-3 py-1 rounded">
                        <span class="material-icons text-sm">home</span>
                        <span>Painel</span>
                    </a>
                    <a href="{{ route('biblioteca.emprestimos') }}"
                       class="flex items-center space-x-1 hover:bg-green-600 px-3 py-1 rounded">
                        <span class="material-icons text-sm">swap_horiz</span>
                        <span>Meus Empréstimos</span>
                    </a>
                    <a href="{{ route('logout') }}" 
                       class="flex items-center space-x-1 hover:bg-green-600 px-3 py-1 rounded"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="material-icons text-sm">exit_to_app</span>
                        <span>Sair</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

</body>
</html>
