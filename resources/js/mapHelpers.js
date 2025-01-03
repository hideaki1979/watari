let map;
let markers = [];

// 地図の初期化
export async function initMap() {
    try {
        // Google Maps JavaScript APIで必要なライブラリをロード
        const { Map } = await google.maps.importLibrary("maps");

        const mapElement = document.getElementById('map');
        if (!mapElement) {
            console.error('Map element not found');
            return;
        }
        map = new Map(mapElement, {
            center: {
                lat: 35.6895,
                lng: 139.6917
            },
            zoom: 13,
            mapId: "c1be8225dc3df8f",
        });

    } catch (error) {
        console.error('Error initializing map:', error);
    }
}

// サーバーからロケーションデータを取得
export function fetchLocations(query) {
    fetch(`api/locations?query=${query}`)
        .then(response => response.json())
        .then(data => {
            clearMarkers();
            data.forEach(location => {
                addMarker(location);
            });
        });
}

// マーカーを地図に追加
export async function addMarker(location) {
    try {
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
        const marker = new AdvancedMarkerElement({
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
    } catch (error) {
        console.error('Error adding marker:', error);
    }        
}

// マーカーをクリア
function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}

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
export function updateMarkers(distance, query) {
    const center = map.getCenter(); // 地図の中心位置を取得
    const centerLat = center.lat();
    const centerLng = center.lng();

    // 現在のマーカーをすべてクリア
    clearMarkers();

    // 新しい距離に基づいてマーカーを表示
    fetch(`api/locations?query=${query}`) // すべてのロケーションを取得
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

