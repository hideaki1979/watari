import { initMap, searchLocations, updateDistance } from "./mapHelpers";

document.addEventListener('DOMContentLoaded', async () => {
    
    const searchBar = document.getElementById('search-bar');
    const distanceSelect = document.getElementById('distance-select');

    // 地図の初期化を待つ
    await initMap();

    // 初期値の設定
    let currentQuery = searchBar?.value || '';
    let currentDistance = distanceSelect?.value || '100';

    distanceSelect?.addEventListener('change', () => {
        console.log(`距離変更：${distanceSelect.value}`);
        updateDistance(distanceSelect.value);
    });

    searchBar?.addEventListener('keypress', async (event) => {
        if(event.key === "Enter"){
            event.preventDefault();
            const query = searchBar.value;

            // ページリロードなしでURLを更新
            const url = new URL(window.location.href);
            url.searchParams.set("query", query);
            window.history.pushState({}, '', url);
            await searchLocations(query);
        }
    });

    // キーワードがある場合は検索処理を実施
    if(currentQuery) {
        searchLocations(currentQuery);
    }
});