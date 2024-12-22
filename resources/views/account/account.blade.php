<x-accountcom-layout>
<div class="flex flex-col items-center justify-between my-6">
    <!-- Header -->
    <x-slot name="header">
        <div class="w-full py-4">
            <h1 class="text-lg font-bold">{{ Auth::user()->name }} </h1>
            <h2 class="text-lg font-bold text-center">アカウント管理</h2>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="flex flex-col items-center gap-4">
        <div class="grid grid-cols-2 gap-4">
            <!-- 本人確認 -->
            <a href="#" class="block w-32 h-32 p-6 bg-gray-100 flex flex-col items-center justify-center shadow-md hover:bg-gray-200">
                <i class="fa-solid fa-address-card w-8 h-8 mb-2"></i>
                <span>本人確認</span>
            </a>
            <!-- 出品登録 -->
            <a href="{{ route('items.index', ['user_id' => Auth::user()->id]) }}" class="block w-32 h-32 p-6 bg-gray-100 flex flex-col items-center justify-center shadow-md hover:bg-gray-200">
                <i class="fa-solid fa-hand-holding-heart w-8 h-8 mb-2"></i>
                <span>出品登録</span>
            </a>
            <!-- 購入履歴 -->
            <a href="#" class="block w-32 h-32 p-6 bg-gray-100 flex flex-col items-center justify-center shadow-md hover:bg-gray-200">
                <i class="fa-solid fa-clock-rotate-left w-8 h-8 mb-2"></i>
                <span>購入履歴</span>
            </a>
            <!-- 引渡場所 -->
            <a href="{{ route('deliveries.index', ['user_id' => Auth::user()->id]) }}" class="block w-32 h-32 p-6 bg-gray-100 flex flex-col items-center justify-center shadow-md hover:bg-gray-200">
                <i class="fa-solid fa-people-arrows w-8 h-8 mb-2"></i>
                <span>引渡場所</span>
            </a>
        </div>

        <!-- Logout -->
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-blue-600 hover:underline">
            ログアウト
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

    <!-- Footer -->
    @section('footer')
    <x-footer />
    @endsection
</div>
</x-accountcom-layout>