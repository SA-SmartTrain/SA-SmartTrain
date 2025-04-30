const map = L.map('map').setView([-26.3045, -48.8487], 13);

var layer = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
    minZoom: 0,
    maxZoom: 20,
    attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    ext: 'png'
});
layer.addTo(map);

let clickPoints = [];
let userMarkers = [];
let userPolylines = [];

map.on('click', function(e) {
    const latlng = e.latlng;
    clickPoints.push(latlng);

    const marker = L.marker(latlng).addTo(map);
    userMarkers.push(marker);

    if (clickPoints.length === 2) {
        const line = L.polyline(clickPoints, { color: 'rgb(242,211,124)' }).addTo(map);
        userPolylines.push(line);
        clickPoints = [];
    }
});

map.on('dblclick', function() {
    userMarkers.forEach(m => map.removeLayer(m));
    userPolylines.forEach(l => map.removeLayer(l));
    userMarkers = [];
    userPolylines = [];
    clickPoints = [];
});