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
                <a href="{{ route('items.map', ['query' => '塩']) }}" class="block">
                    <img src="{{ asset('images/salt_sample.png') }}" alt="塩" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'ソース']) }}" class="block">
                    <img src="{{ asset('images/sause_sample.jpg') }}" alt="ソース" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => '醤油']) }}" class="block">
                    <img src="{{ asset('images/soysause_sample.jpg') }}" alt="醤油" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'にんにく']) }}" class="block">
                    <img src="{{ asset('images/garlic_sample.jpeg') }}" alt="にんにく" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'しょうが']) }}" class="block">
                    <img src="{{ asset('images/ginger_sample.jpg') }}" alt="しょうが" class="w-full h-32 object-cover rounded-lg">
                </a>
                <a href="{{ route('items.map', ['query' => 'マヨネーズ']) }}" class="block">
                    <img src="{{ asset('images/mayonnaise.jpeg') }}" alt="マヨネーズ" class="w-full h-32 object-cover rounded-lg">
                </a>
            </div>
        </main>

        <!-- Footer -->
        <x-footer-ver2 />
    </div>
</body>
</html>
