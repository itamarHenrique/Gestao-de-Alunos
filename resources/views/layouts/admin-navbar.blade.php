<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Painel Administrativo')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-sans">

    <!-- Barra de Navegação -->
    <nav class="bg-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span class="material-icons text-2xl">school</span>
                <h1 class="text-xl font-bold">Instituição Educacional</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="material-icons">account_circle</span>
                <span>Admin</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:bg-blue-700 px-3 py-1 rounded flex items-center">
                        <span class="material-icons">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="p-8">
        @yield('content')
    </main>

</body>
</html>
