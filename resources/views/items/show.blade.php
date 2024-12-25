<!-- resources/views/items/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="w-full py-4">
            <h1 class="text-lg font-bold">{{ Auth::user()->name }} </h1>
            <h2 class="text-lg font-bold text-center">商品詳細</h2>
        </div>
    </x-slot>
    <div class="bg-white pb-20"><!-- フッターバーの高さ分のパディングを追加 -->
        <!-- ヘッダー部分 -->
        <div class="relative h-48">
        <x-slot name="header">
        <div class="w-full py-4">
            <h1 class="text-lg font-bold">{{ Auth::user()->name }} </h1>
            <h2 class="text-lg font-bold text-center">商品詳細</h2>
        </div>
    </x-slot>
            @if($item->image_1)
                <img src="{{ asset($item->image_1) }}" alt="{{ $item->item_name }}" class="w-full h-full object-cover">
            @endif
            <div class="absolute top-4 left-4">
                <a href="{{ route('items.index') }}" class="text-white bg-black bg-opacity-50 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- 商品情報 -->
        <div class="p-4">
            <h1 class="text-xl font-bold mb-2">{{ $item->item_name }}</h1>
            
            <!-- 出品者情報 -->
            <div class="flex items-center mb-4">
                <div class="ml-2">
                    <p class="text-gray-600">{{ $item->user->name }}</p>
                    <div class="flex items-center">
                        <span class="text-yellow-400">★</span>
                        <span class="text-gray-600 text-sm">4.2 (25件)</span>
                    </div>
                </div>
            </div>

            <!-- 住所情報 -->
            <p class="text-sm text-gray-600 mb-4">
            {{ $delivery->address ?? '住所が登録されていません' }}
            </p>

            <!-- 注文状況 -->
            <div class="bg-gray-100 rounded-lg p-3 mb-4">
                <p class="text-sm text-gray-600">10人が商品を注文</p>
            </div>

            <!-- 商品説明 -->
            <div class="mb-6">
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <p class="text-gray-800">{{ $item->description }}</p>
                    <p class="text-gray-800 mt-2">{{ number_format($item->price) }}円/100g</p>
                    <p class="text-gray-600 text-sm mt-1">賞味期限: {{ \Carbon\Carbon::parse($item->expiry_date)->format('Y年m月d日') }}</p>
                </div>
            </div>

            <!-- 購入ボタン -->
            <form action="{{ route('items.buy', $item) }}" method="POST" class="mb-6">
                @csrf
                <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg font-bold hover:bg-blue-600 transition duration-200">
                    購入する
                </button>
            </form>

            <!-- 関連商品 -->
            @if($relatedItems->isNotEmpty())
            <div class="mt-8">
                <h2 class="text-lg font-bold mb-4">{{ $item->user->name }}さんの他の出品商品</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($relatedItems as $relatedItem)
                    <div class="border rounded-lg p-3">
                        <a href="{{ route('items.show', $relatedItem) }}" class="block">
                            @if($relatedItem->image_1)
                                <img src="{{ asset($relatedItem->image_1) }}" 
                                     alt="{{ $relatedItem->item_name }}" 
                                     class="w-full h-32 object-cover rounded-lg mb-2">
                            @endif
                            <p class="font-bold">{{ $relatedItem->item_name }}</p>
                            <p class="text-sm text-gray-600">{{ number_format($relatedItem->price) }}円</p>
                            <p class="text-xs text-gray-500 line-clamp-2">{{ $relatedItem->description }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
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
</x-app-layout>