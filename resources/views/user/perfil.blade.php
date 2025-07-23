<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Perfil do Aluno</h2>
        
        <div class="space-y-4">
            <div>
                <label class="block text-gray-600 text-sm">Nome Completo</label>
                <p class="text-gray-800 font-medium">{{ $usuario->primeiro_nome }} {{ $usuario->sobrenome }}</p>
            </div>
            
            <div>
                <label class="block text-gray-600 text-sm">Email</label>
                <p class="text-gray-800 font-medium">{{ $usuario->email }}</p>
            </div>

            <div>
                <label class="block text-gray-600 text-sm">Celular</label>
                <p class="text-gray-800 font-medium">{{ $usuario->celular }}</p>
            </div>

            <div>
                <label class="block text-gray-600 text-sm mb-2">Endereço
                </label>

            @foreach ($usuario->enderecos as $endereco)
                <div class="bg-gray-50 border border-gray-200 rounded-md p-4 space-y-2">
                    <p class="text-gray-800"><strong>Rua:</strong> {{ $endereco->rua }}</p>
                    <p class="text-gray-800"><strong>CEP:</strong> {{ $endereco->cep }}</p>
                    <p class="text-gray-800"><strong>Número:</strong> {{ $endereco->numero_da_casa }}</p>
                    <p class="text-gray-800"><strong>Bairro:</strong> {{ $endereco->bairro }}</p>
                </div>
            @endforeach
        </div>

        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('aluno.dashboard') }}" class="text-green-600 hover:underline">← Voltar ao Painel</a>
        </div>
    </div>
</body>
</html>
