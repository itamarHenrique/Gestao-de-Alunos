<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    {{-- Google Fonts: Manrope --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <style>
        .font-manrope {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>
<body class="bg-[#0A1E3F] flex items-center justify-center min-h-screen px-4">

    <div class="bg-[#3ED9D4] p-8 md:p-10 rounded-xl w-full max-w-sm shadow-xl text-center">
        
        {{-- Título LOGIN --}}
        <h1 class="text-white text-4xl md:text-[64px] font-manrope font-bold leading-none mb-8">
            LOGIN
        </h1>

        {{-- Formulário de Login --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-4 text-left">
            @csrf

            <div>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="E-mail" 
                    required
                    class="w-full p-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-600"
                >
            </div>

            <div>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Senha" 
                    required
                    class="w-full p-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-600"
                >
            </div>

            <button 
                type="submit" 
                class="mt-4 w-full bg-[#0A1E3F] text-white py-3 rounded-lg hover:bg-[#092037] transition-colors font-semibold"
            >
                Entrar
            </button>
        </form>
    </div>

</body>
</html>
