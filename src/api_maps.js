const map = L.map('map').setView([-26.3045, -48.8487], 13);

var layer = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
	minZoom: 0,
	maxZoom: 20,
	attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	ext: 'png'
});
const positions = [[-26.3045, -48.8487], [-26.2771, -48.8627]]

layer.addTo(map);

const marker = L.marker(positions[0])
marker.addTo(map)

L.marker(positions[positions.length - 1]).addTo(map)

const polyline = L.polyline(positions, { color: 'rgb(242,211,124)'})
polyline.addTo(map)
