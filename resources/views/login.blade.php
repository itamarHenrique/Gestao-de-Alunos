<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
      body { font-family: 'Manrope', sans-serif; }
      .input-error { border: 1px solid #ef4444; }
    </style>
</head>
<body class="flex items-center justify-center h-screen bg-blue-900">
    <div class="bg-cyan-400 p-8 rounded-2xl w-80 shadow-md">
        <div class="flex justify-center mb-4">
            <span class="material-icons text-4xl text-white">school</span>
        </div>
        <h1 class="text-2xl font-bold text-center mb-6 text-white">ACESSO AO SISTEMA</h1>
        
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm flex items-center">
                <span class="material-icons mr-2 text-red-500">error</span>
                {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <div class="flex items-center bg-white rounded-full px-3">
                    <span class="material-icons text-gray-500 mr-2">email</span>
                    <input
                        type="email"
                        name="email"
                        placeholder="Email institucional"
                        class="w-full p-3 bg-transparent placeholder:text-gray-500 focus:outline-none"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        @if($errors->has('email')) class="input-error" @endif
                    />
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex items-center bg-white rounded-full px-3">
                    <span class="material-icons text-gray-500 mr-2">lock</span>
                    <input
                        type="password"
                        name="password"
                        placeholder="Senha de acesso"
                        class="w-full p-3 bg-transparent placeholder:text-gray-500 focus:outline-none"
                        required
                        @if($errors->has('password')) class="input-error" @endif
                    />
                </div>
            </div>
            
            <button
                type="submit"
                class="w-full bg-blue-800 text-white font-semibold py-3 rounded-full hover:bg-blue-700 transition flex items-center justify-center"
            >
                <span class="material-icons mr-2">login</span>
                ACESSAR SISTEMA
            </button>
        </form>
    </div>
</body>
</html>