<x-accountcom-layout>
    <!-- Header -->
    <x-slot name="header">
        <div class="w-full py-4">
            <h1 class="text-lg font-bold">{{ Auth::user()->name }} </h1>
            <h2 class="text-lg font-bold text-center">出品登録</h2>
            <div>
                <a href="{{ route('account') }}" class="text-blue-500 hover:underline">戻る</a>
            </div>
        </div>
    </x-slot>

    <!-- Registration Form -->
    <div class="container mx-auto px-4 py-6">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <!-- Image Upload -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                @for ($i = 1; $i <= 4; $i++)
                    <label class="block bg-gray-200 w-full h-32 rounded flex items-center justify-center cursor-pointer">
                        <span class="text-gray-500">No Image</span>
                        <input type="file" name="image_{{ $i }}" accept="image/*" class="hidden" onchange="handleFileSelect(event, {{ $i }})">
                    </label>
                @endfor
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-bold mb-2">カテゴリー</label>
                <select name="category" id="category" class="block w-full border-gray-300 rounded focus:ring focus:ring-green-500">
                    <option value="01">調味料</option>
                    <option value="02">食材</option>
                </select>
            </div>

            <!-- Name -->
            <div class="mb-4">
                <label for="item_name" class="block text-gray-700 font-bold mb-2">商品名</label>
                <input type="text" name="item_name" id="name" class="block w-full border-gray-300 rounded focus:ring focus:ring-green-500">
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">値段</label>
                <input type="number" name="price" id="price" class="block w-full border-gray-300 rounded focus:ring focus:ring-green-500">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">説明</label>
                <textarea name="description" id="description" rows="3" class="block w-full border-gray-300 rounded focus:ring focus:ring-green-500"></textarea>
            </div>

            <!-- Expiry Date -->
            <div class="mb-4">
                <label for="expiry_date" class="block text-gray-700 font-bold mb-2">賞味期限</label>
                <input type="date" name="expiry_date" id="expiry_date" class="block w-full border-gray-300 rounded focus:ring focus:ring-green-500">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">出品登録</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    @section('footer')
    <x-footer-ver2 />
    @endsection
    <script>
        function handleFileSelect(event, index) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    input.previousElementSibling.innerHTML = `<img src="${e.target.result}" alt="Selected Image" class="w-full h-full object-cover rounded">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-accountcom-layout>
