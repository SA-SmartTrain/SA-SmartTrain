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

const apiKey = '5b3ce3597851110001cf62486b3fdc2f343b45e2bf0bdcfb17af56bc'; 

map.on('click', async function(e) {
    const latlng = e.latlng;
    clickPoints.push(latlng);

    const marker = L.marker(latlng).addTo(map);
    userMarkers.push(marker);

    if (clickPoints.length === 2) {
        await desenharRota(clickPoints[0], clickPoints[1]);
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
            await desenharRota(clickPoints[0], clickPoints[1]);
            clickPoints = [];
        }
    }
}

async function desenharRota(pontoA, pontoB) {
    const response = await fetch('https://api.openrouteservice.org/v2/directions/driving-car/geojson', {
        method: 'POST',
        headers: {
            'Authorization': apiKey,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            coordinates: [
                [pontoA.lng, pontoA.lat],
                [pontoB.lng, pontoB.lat]
            ]
        })
    });

    if (!response.ok) {
        alert("Erro ao buscar rota.");
        return;
    }

    const data = await response.json();

    const rota = L.geoJSON(data, {
        style: { color: 'rgb(242,211,124)', weight: 4 }
    }).addTo(map);

    userPolylines.push(rota);
}

document.getElementById('destinoStart').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') localizarDestino('destinoStart');
});
document.getElementById('destinoFinal').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') localizarDestino('destinoFinal');
});
