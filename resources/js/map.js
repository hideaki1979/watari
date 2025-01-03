import { initMap, fetchLocations, updateMarkers } from "./mapHelpers";

document.addEventListener('DOMContentLoaded', async () => {
    
    const searchBar = document.getElementById('search-bar');
    const distanceSelect = document.getElementById('distance-select');

    // 地図の初期化を待つ
    await initMap();

    if (distanceSelect) {
        distanceSelect.addEventListener('change', () => {
            const distance = distanceSelect.value;
            const query = searchBar ? searchBar.value : '';
            updateMarkers(distance, query);
        });
    }

    if (searchBar) {
        searchBar.addEventListener('keypress', (event) => {
            if(event.key === "Enter"){
                const query = searchBar.value;
                const url = new URL(window.location.href);
                url.searchParams.set("query", query);
                window.location.href = url.toString();
                fetchLocations(query);
            }
        });
    }

    const query = "{{ $query ?? '' }}";
    if(query) {
        fetchLocations(query);
    }
});