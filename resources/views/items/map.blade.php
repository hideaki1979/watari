<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/3893656067.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/map.js'])
</head>



<body class="bg-gray-100 font-sans">
    <div class="max-w-md mx-auto h-screen flex flex-col border border-gray-300 bg-white">
        <!-- Header -->
        <header class="p-3 bg-white">
            <div class="flex items-center space-x-2 mb-2">
                <input
                    type="text"
                    id="search-bar"
                    placeholder="検索"
                    value="{{ $query ?? '' }}"
                    class="flex-1 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="flex items-center space-x-2">
                <select
                    id="distance-select"
                    class="p-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="100">100m</option>
                    <option value="500">500m</option>
                    <option value="1000">1km</option>
                    <option value="2000">2km</option>
                    <option value="5000">5km</option>
                </select>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 relative">
            <div class="absolute inset-0">
                <!-- 地図を表示する部分 -->
                <div id="map" class="w-full h-full"></div>
            </div>
        </main>

        <!-- Detail Modal -->
        <div id="detail-modal" class="absolute bottom-0 inset-x-0 bg-white border-t border-gray-300 shadow-lg p-4 hidden">
            <div class="flex flex-col">
                <!-- ユーザー名と距離 -->
                <div class="flex justify-between items-center mb-4">
                    <h2 id="user-name" class="text-lg font-bold"></h2> <!-- ユーザー名 -->
                    <span id="distance" class="text-sm text-gray-500"></span> <!-- 距離 -->
                </div>

                <!-- 該当商品の画像 -->
                <div id="main-item" class="flex justify-center mb-4">
                    <a id="main-item-link" href="#" class="block">
                        <img id="main-item-image" src="" alt="該当商品" class="w-32 h-32 rounded-lg object-cover">
                    </a>
                </div>

                <!-- 他の出品物 -->
                <p>他の出品物</p>
                <div id="user-items" class="grid grid-cols-3 gap-4">
                    <!-- 他の出品物がここに追加される -->
                </div>

                <!-- 閉じるボタン -->
                <button class="mt-4 w-full p-2 bg-gray-300 text-sm font-medium text-gray-700 rounded-lg" onclick="closeModal()">閉じる</button>
            </div>
        </div>

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
    </div>
    <!-- Google Maps API用スクリプト -->

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary",
                q = "__ib__", m = document, b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}), r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a);
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n));
            })({
                key: "AIzaSyCgq9tyJWnjgm0qPKeWmGzCenlTbrq7Tr8",
                v: "weekly",
                libraries: ["places", "marker"]
        });
    </script>
    <script>

        function closeModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }

        function showDetails(location) {
            // ユーザー名を設定
            document.getElementById('user-name').innerText = location.user_name;

            // 距離を設定
            document.getElementById('distance').innerText = location.distance ? `${location.distance}m` : '';

            // 該当商品の画像とリンクを設定
            const mainItemImage = document.getElementById('main-item-image');
            mainItemImage.src = location.image_1; // 該当商品の画像を設定
            mainItemImage.alt = location.item_name;

            const mainItemLink = document.getElementById('main-item-link');
            mainItemLink.href = `items/${location.item_id}`; // 該当商品のリンクを設定

            // 他の出品物を設定
            const userItemsContainer = document.getElementById('user-items');
            userItemsContainer.innerHTML = ''; // 既存の内容をクリア
            location.items.forEach(item => {
                const itemDiv = document.createElement('div');
                itemDiv.className = "flex flex-col items-center text-center";
                itemDiv.innerHTML = `
            <img src="${item.image_1}" alt="${item.item_name}" class="w-16 h-16 rounded-lg mb-2">
            <span class="text-sm text-gray-700">${item.item_name}</span>
            `;
                userItemsContainer.appendChild(itemDiv);
            });

            // モーダルを表示
            document.getElementById('detail-modal').classList.remove('hidden');
        }

    </script>
</body>
</html>