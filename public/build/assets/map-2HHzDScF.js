let d,i=[];async function f(){try{const{Map:e}=await google.maps.importLibrary("maps"),t=document.getElementById("map");if(!t){console.error("Map element not found");return}d=new e(t,{center:{lat:35.6895,lng:139.6917},zoom:13,mapId:"c1be8225dc3df8f"})}catch(e){console.error("Error initializing map:",e)}}function u(e){fetch(`api/locations?query=${e}`).then(t=>t.json()).then(t=>{m(),t.forEach(n=>{h(n)})})}async function h(e){try{const{AdvancedMarkerElement:t}=await google.maps.importLibrary("marker"),n=new t({position:{lat:parseFloat(e.latitude),lng:parseFloat(e.longitude)},map:d,title:e.item_name});n.addListener("click",()=>{showDetails(e)}),i.push(n)}catch(t){console.error("Error adding marker:",t)}}function m(){i.forEach(e=>e.setMap(null)),i=[]}function M(e,t,n,r){const a=p=>p*Math.PI/180,c=a(n-e),s=a(r-t),l=Math.sin(c/2)*Math.sin(c/2)+Math.cos(a(e))*Math.cos(a(n))*Math.sin(s/2)*Math.sin(s/2);return 6371e3*(2*Math.atan2(Math.sqrt(l),Math.sqrt(1-l)))}function y(e,t){const n=d.getCenter(),r=n.lat(),o=n.lng();m(),fetch(`api/locations?query=${t}`).then(a=>a.json()).then(a=>{a.forEach(c=>{M(r,o,c.latitude,c.longitude)<=e&&h(c)})})}document.addEventListener("DOMContentLoaded",async()=>{const e=document.getElementById("search-bar"),t=document.getElementById("distance-select");await f(),t&&t.addEventListener("change",()=>{const r=t.value,o=e?e.value:"";y(r,o)}),e&&e.addEventListener("keypress",r=>{if(r.key==="Enter"){const o=e.value,a=new URL(window.location.href);a.searchParams.set("query",o),window.location.href=a.toString(),u(o)}}),u("{{ $query ?? '' }}")});
