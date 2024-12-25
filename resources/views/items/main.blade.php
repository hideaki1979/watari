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
                    class="w-full p-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
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
                <h2 class="text-lg font-medium text-gray-700 px-5 mb-2">調味料から探す</h2>
                <a href="{{ route('items.seasonings') }}" class="text-blue-500 px-5 mb-2 inline-block">調味料から探す</a>
                <div class="flex overflow-x-auto px-3 gap-3">
                    <img src="{{ asset('images/salt_sample.png') }}" alt="調味料1" class="w-36 h-36 object-cover rounded-lg">
                    <img src="{{ asset('images/sause_sample.jpg') }}" alt="調味料2" class="w-36 h-36 object-cover rounded-lg">
                    <img src="{{ asset('images/soysause_sample.jpg') }}" alt="調味料3" class="w-36 h-36 object-cover rounded-lg">
                    <img src="{{ asset('images/salt_sample.png') }}" alt="調味料1" class="w-36 h-36 object-cover rounded-lg">
                    <img src="{{ asset('images/sause_sample.jpg') }}" alt="調味料2" class="w-36 h-36 object-cover rounded-lg">
                    <img src="{{ asset('images/soysause_sample.jpg') }}" alt="調味料3" class="w-36 h-36 object-cover rounded-lg">
                </div>
            </section>

            <!-- Section 3 -->
            <section class="my-5">
                <h2 class="text-lg font-medium text-gray-700 px-5 mb-2">食品から探す</h2>
                <a href="{{ route('items.foods') }}" class="text-blue-500 px-5 mb-2 inline-block">食品から探す</a>
                <div class="flex overflow-x-auto px-3 gap-3">
                    <img src="https://via.placeholder.com/150" alt="食品1" class="w-36 h-36 object-cover rounded-lg">
                    <img src="https://via.placeholder.com/150" alt="食品2" class="w-36 h-36 object-cover rounded-lg">
                    <img src="https://via.placeholder.com/150" alt="食品3" class="w-36 h-36 object-cover rounded-lg">
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="flex justify-around p-3 bg-gray-800 text-white">
            <button class="text-lg hover:text-blue-400">ホーム</button>
            <button class="text-lg hover:text-blue-400">アカウント</button>
        </footer>
    </div>
</body>
</html>


