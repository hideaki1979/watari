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
        <header class="p-3 bg-white">
            <div class="w-full">
                <input
                    type="text"
                    placeholder="検索"
                    class="w-full p-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Section 1 -->
            <!-- <section class="my-5">
                <h2 class="text-lg font-medium text-gray-700 px-5 mb-2">お料理から探す</h2>
                <a href="cooking.html" class="text-blue-500 px-5 mb-2 inline-block">お料理から探す</a>
                <div class="flex overflow-x-auto px-3 gap-3">
                    <img src="https://via.placeholder.com/150" alt="料理1" class="w-36 h-36 object-cover rounded-lg">
                    <img src="https://via.placeholder.com/150" alt="料理2" class="w-36 h-36 object-cover rounded-lg">
                    <img src="https://via.placeholder.com/150" alt="料理3" class="w-36 h-36 object-cover rounded-lg">
                </div>
            </section> -->

            <!-- Section 2 -->
            <section class="my-5">
                <a href="{{ route('items.seasonings') }}" class="text-gray-700 px-5 mb-2 inline-block">調味料から探す</a>
                <div class="grid grid-cols-3 gap-3 px-3">
                    <a href="{{ route('items.map', ['query' => '塩']) }}" class="block">
                        <img src="{{ asset('images/salt_sample.png') }}" alt="塩" class="w-full h-32 object-cover rounded-lg">
                    </a>
                    <a href="{{ route('items.map', ['query' => 'ソース']) }}" class="block">
                        <img src="{{ asset('images/sause_sample.jpg') }}" alt="ソース" class="w-full h-32 object-cover rounded-lg">
                    </a>
                    <a href="{{ route('items.map', ['query' => '醤油']) }}" class="block">
                        <img src="{{ asset('images/soysause_sample.jpg') }}" alt="醤油" class="w-full h-32 object-cover rounded-lg">
                    </a>
                </div>
            </section>

            <section class="my-5">
                <a href="{{ route('items.foods') }}" class="text-gray-700 px-5 mb-2 inline-block">食品から探す</a>
                <div class="grid grid-cols-3 gap-3 px-3">
                    <a href="{{ route('items.map', ['query' => 'バター']) }}" class="block">
                        <img src="{{ asset('images/butter.jpg') }}" alt="バター" class="w-full h-32 object-cover rounded-lg">
                    </a>
                    <a href="{{ route('items.map', ['query' => 'ネギ']) }}" class="block">
                        <img src="{{ asset('images/negi.jpeg') }}" alt="ネギ" class="w-full h-32 object-cover rounded-lg">
                    </a>
                    <a href="{{ route('items.map', ['query' => 'パスタ']) }}" class="block">
                        <img src="{{ asset('images/pasta.jpeg') }}" alt="パスタ" class="w-full h-32 object-cover rounded-lg">
                    </a>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <x-footer-ver2 />
    </div>
</body>
</html>