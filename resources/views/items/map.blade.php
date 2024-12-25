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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyRmgWj281YYn-lZ3xYsJnIcXizPErHZM&libraries=places"></script> <!-- Google Maps API -->
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
        let map;
        let markers = [];

        // 地図の初期化
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 35.6895,
                    lng: 139.6917
                }, // 初期位置：東京
                zoom: 13
            });

            // 検索バーのイベント
            document.getElementById('search-bar').addEventListener('input', function() {
                const query = this.value;
                fetchLocations(query);
            });

            // 距離指定イベント
            document.getElementById('distance-select').addEventListener('change', function() {
                const distance = this.value;
                updateMarkers(distance);
            });
        }

        // サーバーからロケーションデータを取得
        function fetchLocations(query) {
            fetch(`api/locations?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    clearMarkers();
                    data.forEach(location => {
                        addMarker(location);
                    });
                });
        }


        function closeModal() {
            document.getElementById('detail-modal').classList.add('hidden');
        }




        // マーカーを地図に追加
        function addMarker(location) {
            const marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(location.latitude),
                    lng: parseFloat(location.longitude)
                },
                map: map,
                title: location.item_name


            });

            marker.addListener('click', () => {
                showDetails(location);
            });

            markers.push(marker);
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
            mainItemLink.href = `/items/${location.item_id}`; // 該当商品のリンクを設定

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






        // マーカーをクリア
        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
        }

        // 距離によるマーカー更新
        // function updateMarkers(distance) {
        //     // TODO: 距離によるフィルタリングを追加
        // }

        // 現在地図の中心位置からの距離を計算する関数
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371000; // 地球の半径（メートル）
            const toRadians = (deg) => (deg * Math.PI) / 180;

            const dLat = toRadians(lat2 - lat1);
            const dLng = toRadians(lng2 - lng1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRadians(lat1)) *
                Math.cos(toRadians(lat2)) *
                Math.sin(dLng / 2) *
                Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c; // 距離（メートル）
        }

        // 距離によるマーカー更新
        function updateMarkers(distance) {
            const center = map.getCenter(); // 地図の中心位置を取得
            const centerLat = center.lat();
            const centerLng = center.lng();

            // 現在のマーカーをすべてクリア
            clearMarkers();

            // 新しい距離に基づいてマーカーを表示
            fetch(`/api/locations`) // すべてのロケーションを取得
                .then(response => response.json())
                .then(data => {
                    data.forEach(location => {
                        const distanceToMarker = calculateDistance(
                            centerLat,
                            centerLng,
                            location.latitude,
                            location.longitude
                        );

                        if (distanceToMarker <= distance) {
                            addMarker(location);
                        }
                    });
                });
        }





        window.onload = initMap;
    </script>
</body>

</html>