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

async function buscarEndereco(endereco) {
    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`);
    const data = await response.json();
    if (data.length > 0) {
        const { lat, lon } = data[0];
        return L.latLng(lat, lon);
    } else {
        alert(`Endereço não encontrado: ${endereco}`);
        return null;
    }
}

async function localizarDestino(inputId) {
    const endereco = document.getElementById(inputId).value;
    if (!endereco) return;

    const latlng = await buscarEndereco(endereco);
    if (latlng) {
        const marker = L.marker(latlng).addTo(map);
        userMarkers.push(marker);
        clickPoints.push(latlng);

        map.setView(latlng, 15);

        if (clickPoints.length === 2) {
            const line = L.polyline(clickPoints, { color: 'rgb(242,211,124)' }).addTo(map);
            userPolylines.push(line);
            clickPoints = [];
        }
    }
}

document.getElementById('destinoStart').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') localizarDestino('destinoStart');
});
document.getElementById('destinoFinal').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') localizarDestino('destinoFinal');
});
