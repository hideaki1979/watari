<x-app-layout>
  <x-slot name="header">
        <div class="w-full py-4">
            <h1 class="text-lg font-bold">{{ Auth::user()->name }}</h1>
            <h2 class="text-lg font-bold text-center">購入完了</h2>
        </div>
    </x-slot>
    <div class="min-h-screen bg-white">
        {{-- メインコンテンツ --}}
        <div class="px-6 pt-8">
            <h1 class="text-xl font-bold mb-2">ご注文ありがとうございました</h1>
            <p class="text-sm text-gray-600 mb-8">調味料レスキューをご利用いただき、ありがとうございます。今回のレスキューについてご感想をお聞かせください。</p>

            {{-- 画像 --}}
            <div class="mb-8 flex justify-center h-max">
                <img 
                  src="{{ asset('images/shoppingbag.png') }}"  
                  alt="shopping bags" 
                  class="w-4/5 h-auto max-w-md object-contain"
                >
            </div>

            {{-- ボタン群 --}}
            <div class="space-y-3">
                <button class="w-full bg-black text-white py-4 rounded">
                    レスキューを評価する
                </button>
                <button class="w-full bg-gray-200 text-black py-4 rounded">
                    閉じる
                </button>
            </div>
        </div>

       <!-- フッターバー -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-3">
        <div class="flex justify-around items-center">
            <a href="{{ route('items.main') }}" class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs mt-1">ホーム</span>
            </a>
            <a href="{{ route('account') }}" class="flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-xs mt-1">マイページ</span>
            </a>
        </div>
    </div>
    </div>
</x-app-layout>