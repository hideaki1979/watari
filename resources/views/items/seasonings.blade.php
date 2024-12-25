<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/3893656067.js" crossorigin="anonymous"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
<body class="bg-gray-100 font-sans">
    <div class="max-w-md mx-auto flex flex-col h-[844px] border border-gray-300 bg-white">
        <!-- Header -->
        <header class="p-3 bg-white text-center">
            <h1 class="text-lg font-bold text-gray-800">調味料から探す</h1>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-3 gap-4">
                <img src="https://via.placeholder.com/100" alt="調味料1" class="rounded-lg">
                <img src="https://via.placeholder.com/100" alt="調味料2" class="rounded-lg">
                <img src="https://via.placeholder.com/100" alt="調味料3" class="rounded-lg">
                <img src="https://via.placeholder.com/100" alt="調味料4" class="rounded-lg">
                <img src="https://via.placeholder.com/100" alt="調味料5" class="rounded-lg">
                <img src="https://via.placeholder.com/100" alt="調味料6" class="rounded-lg">
            </div>
        </main>

        <!-- Footer -->
        <footer class="flex justify-around p-3 bg-gray-800 text-white">
            <button class="text-lg hover:text-blue-400">ホーム</button>
            <button class="text-lg hover:text-blue-400">アカウント</button>
        </footer>
    </div>
</body>
</html>
