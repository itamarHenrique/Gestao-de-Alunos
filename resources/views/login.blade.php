<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: 'Manrope', sans-serif;
      }
    </style>
  </head>
  <body class="flex items-center justify-center h-screen bg-blue-900">
    <div class="bg-cyan-400 p-8 rounded-2xl w-80 shadow-md">
      <h1 class="text-2xl font-bold text-center mb-6">LOGIN</h1>
      <form>
        <input
          type="text"
          placeholder="Usuário"
          class="w-full mb-4 p-3 rounded-full bg-white placeholder:text-gray-500 focus:outline-none"
        />
        <input
          type="password"
          placeholder="Senha"
          class="w-full mb-6 p-3 rounded-full bg-white placeholder:text-gray-500 focus:outline-none"
        />
        <button
          type="submit"
          class="w-full bg-white text-black font-semibold py-2 rounded-full hover:bg-gray-200 transition"
        >
          login
        </button>
      </form>
    </div>
  </body>
</html>
