<x-app-layout>
    <div class="flex flex-col h-screen w-full max-w-md mx-auto bg-white">
        {{-- Header --}}
        <header class="flex items-center p-4 border-b">
            <button onclick="window.history.back()" class="flex items-center text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                <span>戻る</span>
            </button>
            <h1 class="flex-1 text-center text-lg font-normal pr-16">引渡場所管理</h1>
        </header>

        {{-- Main Content --}}
        <main class="p-4 h-1/2 overflow-auto pb-20">
            <div class="space-y-4">
                <h3 class="text-base font-medium">引渡場所</h3>
                
                @forelse ($deliveries as $delivery)
                    <p class="text-sm cursor-pointer hover:text-blue-500 transition-colors duration-200" 
                       data-lat="{{ $delivery->latitude }}"
                       data-lng="{{ $delivery->longitude }}"
                       data-address="{{ $delivery->address }}">
                        {{ $delivery->address }}
                    </p>
                @empty
                    <p class="text-sm text-gray-500">
                        登録された引渡場所はありません
                    </p>
                @endforelse

                {{-- Map --}}
                <div id="map-container" class="w-full h-48 bg-gray-100 rounded-lg overflow-hidden relative">
                    <img id="static-map" src="" alt="地図" class="w-full h-full object-cover hidden">
                    <div id="map-placeholder" class="absolute inset-0 flex items-center justify-center text-gray-500">
                        住所をクリックすると地図が表示されます
                    </div>
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

  @push('scripts')
  <script>
  document.addEventListener('DOMContentLoaded', () => {
      // 要素の取得
      const mapImg = document.getElementById('static-map');
      const placeholder = document.getElementById('map-placeholder');
      console.log("こんにちは");
      // クリックイベントの追加
      document.querySelectorAll('[data-lat]').forEach(element => {
          element.addEventListener('click', () => {
              const { lat, lng } = element.dataset;

              // Google Maps Static APIのURL生成
              const mapUrl = `https://maps.googleapis.com/maps/api/staticmap?`
                  + `center=${lat},${lng}`
                  + `&zoom=15`
                  + `&size=400x300`
                  + `&markers=color:red%7C${lat},${lng}`
                  + `&language=ja`
                  + `&key={{ $apiKey }}`;
                  console.log(lat, lng);
              // 地図の表示切り替え
              mapImg.src = mapUrl;
              placeholder.classList.add('hidden');
              mapImg.classList.remove('hidden');
          });
      });
  });
  </script>
@endpush
</x-app-layout>