<!-- Footer -->
<footer class="flex justify-around p-3 bg-gray-800 text-white">
    <a href="{{ route('items.main') }}" class="flex flex-col items-center space-y-1 text-center text-sm hover:text-blue-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m4 18V3m4 18V3m4 18V3" />
        </svg>
        <span>ホーム</span>
    </a>
    <a href="{{ route('account') }}" class="flex flex-col items-center space-y-1 text-center text-sm hover:text-blue-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.24 3.96a4.5 4.5 0 00-.24 9h.24a5.5 5.5 0 00.24-9h-.24zM8 8a4 4 4 0 104 4H8V8zM5 8v8h6m2 4a6 6 0 00-12 0h12z" />
        </svg>
        <span>アカウント</span>
    </a>
</footer>