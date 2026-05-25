<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заметки</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow mb-6">
    <div class="max-w-5xl mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('notes.index') }}" class="font-bold text-indigo-600 text-lg">Заметки</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-800">Выйти</button>
        </form>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-4">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
