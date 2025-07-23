<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

    <!-- Sidebar e Conteúdo Principal -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md h-screen sticky top-0">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Menu</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center p-2 text-blue-800 rounded-lg hover:bg-blue-50">
                            <span class="material-icons mr-3">dashboard</span>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50">
                            <span class="material-icons mr-3">people</span>
                            Alunos
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50">
                            <span class="material-icons mr-3">person</span>
                            Professores
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50">
                            <span class="material-icons mr-3">book</span>
                            Cursos
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50">
                            <span class="material-icons mr-3">settings</span>
                            Configurações
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="flex-1 p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Visão Geral</h2>
                <p class="text-gray-600">Bem-vindo ao painel administrativo</p>
            </div>

            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Total de Alunos</p>
                            <h3 class="text-2xl font-bold">1,245</h3>
                        </div>
                        <span class="material-icons text-blue-500 text-3xl">school</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Total de Professores</p>
                            <h3 class="text-2xl font-bold">48</h3>
                        </div>
                        <span class="material-icons text-green-500 text-3xl">person</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Cursos Ativos</p>
                            <h3 class="text-2xl font-bold">12</h3>
                        </div>
                        <span class="material-icons text-purple-500 text-3xl">book</span>
                    </div>
                </div>
            </div>

            <!-- Tabela Recente -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-4">Últimos Alunos Cadastrados</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matrícula</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">João Silva</td>
                                <td class="px-6 py-4 whitespace-nowrap">2023001</td>
                                <td class="px-6 py-4 whitespace-nowrap">Informática</td>
                                <td class="px-6 py-4 whitespace-nowrap">10/05/2023</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Maria Oliveira</td>
                                <td class="px-6 py-4 whitespace-nowrap">2023002</td>
                                <td class="px-6 py-4 whitespace-nowrap">Administração</td>
                                <td class="px-6 py-4 whitespace-nowrap">09/05/2023</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Carlos Souza</td>
                                <td class="px-6 py-4 whitespace-nowrap">2023003</td>
                                <td class="px-6 py-4 whitespace-nowrap">Enfermagem</td>
                                <td class="px-6 py-4 whitespace-nowrap">08/05/2023</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>