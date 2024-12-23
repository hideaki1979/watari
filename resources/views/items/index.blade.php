<x-accountcom-layout>
    <!-- Header -->
    <x-slot name="header">
        <div class="w-full py-4">
            <h1 class="text-lg font-bold">{{ Auth::user()->name }} </h1>
            <h2 class="text-lg font-bold text-center">出品管理</h2>
        </div>
    </x-slot>
    <div class="p-4">
        <a href="{{ route('account') }}" class="text-blue-500 hover:underline">戻る</a>

        <!-- タブ -->
        <div class="mt-4">
            <div class="flex border-b">
                <button id="tab-available" class="tab-button px-4 py-2 border-b-2 border-green-500 text-green-500">出品中</button>
                <button id="tab-sold" class="tab-button px-4 py-2 text-gray-500">売却済</button>
            </div>
            <div id="available-items" class="tab-content mt-4">
                <!-- 出品中データを表示 -->
                @foreach($availableItems as $item)
                    <div class="flex items-center mb-4">
                        <img src="{{ $item->image_1 }}" alt="{{ $item->item_name }}" class="w-16 h-16 object-cover rounded">
                        <div class="ml-4">
                            <p class="text-gray-700">{{ $item->item_name }}</p>
                            <p class="text-sm text-gray-500">期限: {{ $item->expiry_date }}</p>
                            <p class="text-sm text-gray-500">{{ $item->price }}円</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="sold-items" class="tab-content mt-4 hidden">
                <!-- 売却済データを表示 -->
                @foreach($soldItems as $item)
                    <div class="flex items-center mb-4">
                        <img src="{{ $item->image_1 }}" alt="{{ $item->item_name }}" class="w-16 h-16 object-cover rounded">
                        <div class="ml-4">
                            <p class="text-gray-700">{{ $item->item_name }}</p>
                            <p class="text-sm text-gray-500">期限: {{ $item->expiry_date }}</p>
                            <p class="text-sm text-gray-500">{{ $item->price }}円</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 出品登録ボタン -->
        <div class="mt-8">
            <a href="{{ route('items.create') }}" class="block text-center bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">出品登録</a>
        </div>
    </>
     <!-- Footer -->
     @section('footer')
     <x-footer />
     @endsection
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab-button');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach((tab, index) => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('border-green-500', 'text-green-500'));
                    tab.classList.add('border-green-500', 'text-green-500');

                    contents.forEach(content => content.classList.add('hidden'));
                    contents[index].classList.remove('hidden');
                });
            });
        });
    </script>
</x-accountcom-layout>
