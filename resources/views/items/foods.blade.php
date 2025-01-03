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
            <h1 class="text-lg font-bold text-gray-800">食品から探す</h1>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-3 gap-4">
                <a href="{{ route('items.map', ['query' => 'バター']) }}" class="block">
                    <img src="{{ asset('images/butter.jpg') }}" alt="バター" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'ネギ']) }}" class="block">
                    <img src="{{ asset('images/negi.jpeg') }}" alt="ネギ" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'パスタ']) }}" class="block">
                    <img src="{{ asset('images/pasta.jpeg') }}" alt="パスタ" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'ラーメン']) }}" class="block">
                    <img src="{{ asset('images/ramen_sample.jpg') }}" alt="ラーメン" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'キャベツ']) }}" class="block">
                    <img src="{{ asset('images/cabbage_sample.jpg') }}" alt="キャベツ" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => '牛肉']) }}" class="block">
                    <img src="{{ asset('images/beef_sample.jpg') }}" alt="牛肉" class="w-full h-32 object-cover rounded-lg">
                </a>
            </div>
        </main>

        <!-- Footer -->
        <x-footer-ver2 />
    </div>
</body>
</html>
