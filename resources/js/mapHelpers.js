let map;                        // GoogleMapsAPIのインスタンスを保持
let markers = [];               // マーカーを配列で管理
let currentQuery = '';          // 現在の検索クエリ
let currentDistance = '100';    // 現在の検索距離

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
        // 東京を中心地に初期設定
        map = new Map(mapElement, {
            // 東京の座標
            center: {
                lat: 35.6895,
                lng: 139.6917
            },
            zoom: 13,
            mapId: "c1be8225dc3df8f",
        });
        // 地図の移動が終わった時のイベントリスナー
        map.addListener('idle', () => {
            updateMarkerForCurrentView();
        });
    } catch (error) {
        console.error('Error initializing map:', error);
    }
}

// 地図移動後の中心位置取得・マーカー更新処理
async function updateMarkerForCurrentView() {
    const center = map.getCenter(); // 地図の中心位置を取得
    console.log(`距離変更Helper_CurrentView：${currentDistance}`);
    const params = new URLSearchParams({
        query: currentQuery,
        distance: currentDistance,
        lat: center.lat(),
        lng: center.lng()
    });

    try {
        const response = await fetch(`api/locations?${params}`);
        if(!response.ok) throw new Error('住所取得処理でエラーが発生しました。');

        const data = await response.json();
        refreshMarker(data);
    } catch(error) {
        console.error('住所取得エラー：', error);
    }
}

// キーワード変更時にマーカー更新
export async function searchLocations(query) {
    currentQuery = query;
    await updateMarkerForCurrentView();    
}

// 距離変更時にマーカー更新
export async function updateDistance(distance) {
    currentDistance = distance;
    console.log(`距離変更Helper：${currentDistance}`);
    await updateMarkerForCurrentView();
}

// マーカー表示をリフレッシュする
async function refreshMarker(locations) {
    clearMarkers(); // マーカーをクリアする
    try {
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

        for(const location of locations) {
            if(!location.latitude || !location.longitude) continue;

            const marker = new AdvancedMarkerElement({
                position: {
                    lat: parseFloat(location.latitude),
                    lng: parseFloat(location.longitude)
                },
                map: map,
                title: location.item_name
            });
    
            marker.addListener('click', () => showDetails(location));
            markers.push(marker);
        }
    } catch (error) {
        console.error('Error adding marker:', error);
    }        
}

// マーカーをクリア
function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}

