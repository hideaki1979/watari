<x-app-layout>
    <div class="flex flex-col h-screen w-full max-w-md mx-auto bg-white">
        {{-- Header --}}
        <header class="flex items-center p-4 border-b">
            {{-- 'back' ルートを javascript:history.back() に変更 --}}
            <a href="javascript:history.back()" class="flex items-center text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                <span>戻る</span>
            </a>
            <h1 class="flex-1 text-center text-lg font-normal pr-16">引渡場所管理</h1>
        </header>

        {{-- Main Content --}}
        <main class="p-4 h-1/2 overflow-auto pb-20">
            <div class="space-y-4">
                <h3 class="text-base font-medium">引渡場所</h3>
                
                @forelse ($deliveries as $delivery)
                    <p class="text-sm">
                        {{ $delivery->address }}
                    </p>
                @empty
                    <p class="text-sm text-gray-500">
                        登録された引渡場所はありません
                    </p>
                @endforelse

                {{-- Map --}}
                <div class="w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                    <img src="{{ asset('images/map-placeholder.jpg') }}" alt="地図" class="w-full h-full object-cover">
                </div>
            </div>
        </main>

        {{-- Register Button --}}
        <div class="p-4">
          <a href="{{ route('deliveries.create') }}" class="block w-full bg-green-500 text-white py-3 rounded-lg font-medium text-center">
        新規登録
    </a>
</div>

        {{-- Bottom Navigation --}}
        <nav class="fixed bottom-0 left-0 w-full flex justify-around items-center border-t p-4 bg-white">
            {{-- 'home' ルートを url() に変更 --}}
            <a href="{{ url('/') }}" class="flex flex-col items-center space-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
            {{-- 'profile' ルートを url() に変更 --}}
            <a href="{{ url('/profile') }}" class="flex flex-col items-center space-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </a>
        </nav>
    </div>
</x-app-layout>