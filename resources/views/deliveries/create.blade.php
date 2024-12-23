<x-app-layout>
    <div class="flex flex-col h-screen w-full max-w-md mx-auto bg-white">
        {{-- Header --}}
        <header class="flex items-center p-4 border-b">
            <a href="javascript:history.back()" class="flex items-center text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                <span>戻る</span>
            </a>
            <h1 class="flex-1 text-center text-lg font-normal pr-16">引渡場所登録</h1>
        </header>

        {{-- Main Content --}}
        <main class="p-4 h-1/2 overflow-auto pb-20">
        <form action="{{ route('deliveries.store') }}" method="POST">
            <div class="space-y-4">
                <h3 class="text-base font-medium">引渡場所</h3>
                
                {{-- Address Input --}}
                <div class="space-y-4">
                    <input type="text" 
                           name="address"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                           placeholder="住所を入力">
                </div>

                {{-- Map --}}
                <div class="w-full h-48 bg-gray-100 rounded-lg overflow-hidden">
                    {{-- Replace with actual map implementation --}}
                    <div class="w-full h-full bg-gray-200"></div>
                </div>
            </div>


        {{-- Register Button --}}
        <div class="p-4">

                @csrf
                <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-medium">
                    登録
                </button>
              </div>
          </form>
        </main>

        {{-- Bottom Navigation --}}
        <nav class="fixed bottom-0 left-0 w-full flex justify-around items-center border-t p-4 bg-white">
            <a href="{{ url('/') }}" class="flex flex-col items-center space-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
            <a href="{{ url('/profile') }}" class="flex flex-col items-center space-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </a>
        </nav>
    </div>
</x-app-layout>