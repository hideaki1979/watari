<x-accountcom-layout>
    <!-- Header -->
    <x-slot name="header">
        <div class="w-full py-4">
            <h1 class="text-lg font-bold">{{ Auth::user()->name }} </h1>
            <h2 class="text-lg font-bold text-center">購入履歴</h2>
            <a href="{{ route('account') }}" class="text-blue-500 hover:underline">戻る</a>
        </div>
    </x-slot>

    <!-- 商品一覧 -->
    <div class="flex-grow pt-20 pb-24 px-4">
        @foreach($purchases as $purchase)
            <div class="flex items-center space-x-4 py-4 border-b">
                <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0">
                    <img 
                        src="{{ asset($purchase->item->image_1) }}" 
                        alt="{{ $purchase->item->item_name }}"
                        class="w-full h-full object-cover rounded-lg"
                    >
                </div>
                <div class="flex-grow min-w-0">
                    <h3 class="text-base sm:text-lg font-medium truncate">{{ $purchase->item->item_name }}</h3>
                    <p class="text-sm text-gray-600">
                        期限：{{ $purchase->item->expiry_date->format('Y/m/d') }}
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="font-semibold">{{ number_format($purchase->item->price) }}円</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer -->
    @section('footer')
    <x-footer-ver2 />
    @endsection
</x-accountcom-layout>