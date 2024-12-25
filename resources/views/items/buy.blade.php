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

        {{-- ボトムナビゲーション --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t flex justify-around p-4">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </button>
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </button>
        </div>
    </div>
</x-app-layout>