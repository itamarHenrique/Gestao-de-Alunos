<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Barra de Navegação -->
    <nav class="bg-green-700 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="material-icons">school</span>
                <span class="font-semibold">Minha Instituição</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm">Olá, {{ $usuario->primeiro_nome }}</span>
                <a href="{{ route('logout') }}" 
                   class="flex items-center space-x-1 hover:bg-green-600 px-3 py-1 rounded"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="material-icons text-sm">exit_to_app</span>
                    <span>Sair</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Meu Painel</h1>
            <p class="text-gray-600">Bem-vindo ao sistema da instituição</p>
        </div>

        <!-- Cards de Informação -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card Matrícula -->
            <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Minha Matrícula</h3>
                        @if(isset($usuario))<p class="text-gray-600">{{ $usuario->matricula }}</p>@endif
                    </div>
                    <span class="material-icons text-green-500 text-3xl">badge</span>
                </div>
            </div>

            <!-- Card Curso -->
            <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Meu Curso</h3>
                        <p class="text-gray-600">Informática</p>
                    </div>
                    <span class="material-icons text-blue-500 text-3xl">book</span>
                </div>
            </div>

            <!-- Card Mensagens -->
            <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Mensagens</h3>
                        <p class="text-gray-600">3 não lidas</p>
                    </div>
                    <span class="material-icons text-yellow-500 text-3xl">email</span>
                </div>
            </div>
        </div>

        <!-- Seção de Avisos -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Avisos Recentes</h2>
            <div class="space-y-4">
                <div class="border-l-4 border-green-500 pl-4 py-2">
                    <h3 class="font-medium">Reunião de Pais</h3>
                    <p class="text-sm text-gray-600">Dia 15/10 às 19h no auditório</p>
                </div>
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <h3 class="font-medium">Prova de Matemática</h3>
                    <p class="text-sm text-gray-600">Será aplicada na próxima segunda-feira</p>
                </div>
            </div>
        </div>

        <!-- Seção de Atividades -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Minhas Atividades</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Disciplina</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Atividade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Matemática</td>
                            <td class="px-6 py-4 whitespace-nowrap">Lista de Exercícios 3</td>
                            <td class="px-6 py-4 whitespace-nowrap">10/10/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Entregue</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Português</td>
                            <td class="px-6 py-4 whitespace-nowrap">Redação Dissertativa</td>
                            <td class="px-6 py-4 whitespace-nowrap">15/10/2023</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pendente</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>