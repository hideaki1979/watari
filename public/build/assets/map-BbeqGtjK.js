let a,c=[],d="",o="100";async function m(){try{const{Map:e}=await google.maps.importLibrary("maps"),t=document.getElementById("map");if(!t){console.error("Map element not found");return}a=new e(t,{center:{lat:35.6895,lng:139.6917},zoom:13,mapId:"c1be8225dc3df8f"}),a.addListener("idle",()=>{s()})}catch(e){console.error("Error initializing map:",e)}}async function s(){const e=a.getCenter();console.log(`距離変更Helper_CurrentView：${o}`);const t=new URLSearchParams({query:d,distance:o,lat:e.lat(),lng:e.lng()});try{const n=await fetch(`api/locations?${t}`);if(!n.ok)throw new Error("住所取得処理でエラーが発生しました。");const r=await n.json();y(r)}catch(n){console.error("住所取得エラー：",n)}}async function u(e){d=e,await s()}async function p(e){o=e,console.log(`距離変更Helper：${o}`),await s()}async function y(e){f();try{const{AdvancedMarkerElement:t}=await google.maps.importLibrary("marker");for(const n of e){if(!n.latitude||!n.longitude)continue;const r=new t({position:{lat:parseFloat(n.latitude),lng:parseFloat(n.longitude)},map:a,title:n.item_name});r.addListener("click",()=>{showDetails(n)}),c.push(r)}}catch(t){console.error("Error adding marker:",t)}}function f(){c.forEach(e=>e.setMap(null)),c=[]}document.addEventListener("DOMContentLoaded",async()=>{const e=document.getElementById("search-bar"),t=document.getElementById("distance-select");await m();let n=(e==null?void 0:e.value)||"";t!=null&&t.value,t==null||t.addEventListener("change",()=>{console.log(`距離変更：${t.value}`),p(t.value)}),e==null||e.addEventListener("keypress",async r=>{if(r.key==="Enter"){r.preventDefault();const i=e.value,l=new URL(window.location.href);l.searchParams.set("query",i),window.history.pushState({},"",l),await u(i)}}),n&&u(n)});
