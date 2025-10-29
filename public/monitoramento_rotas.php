<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Rotas Ferroviárias - Brasil</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            color: #333;
            overflow: hidden;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 350px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .toolbar {
            background: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #map {
            flex: 1;
            background-color: #e0e0e0;
        }

        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            margin: 5px;
            transition: all 0.3s;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-success {
            background-color: #2ecc71;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-warning {
            background-color: #f39c12;
        }

        .btn-warning:hover {
            background-color: #d35400;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .station-list,
        .route-list {
            margin-top: 25px;
        }

        .station-item,
        .route-item {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            border-left: 4px solid #3498db;
        }

        .station-item:hover,
        .route-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .station-item.active {
            background-color: rgba(52, 152, 219, 0.3);
            border-left: 4px solid #2ecc71;
        }

        .route-item {
            border-left: 4px solid #f39c12;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            width: 450px;
            max-width: 90%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .close {
            font-size: 24px;
            cursor: pointer;
            color: #7f8c8d;
        }

        .close:hover {
            color: #34495e;
        }

        .mode-indicator {
            background-color: #f39c12;
            padding: 8px 15px;
            border-radius: 20px;
            margin-left: 10px;
            font-weight: bold;
            color: white;
        }

        .route-creator {
            position: absolute;
            top: 80px;
            right: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
        }

        .instructions {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
            border-left: 4px solid #3498db;
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .status-bar {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
        }

        .station-marker {
            background-color: #e74c3c;
            border: 3px solid white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .temp-marker {
            background-color: #3498db;
            border: 3px solid white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo-icon {
            font-size: 24px;
            margin-right: 10px;
        }

        .control-group {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .control-group .btn {
            flex: 1;
            min-width: 120px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <div class="logo-icon"><i class="fas fa-train"></i></div>
                <h1>Rotas Ferroviárias</h1>
            </div>

            <div class="control-group">
                <button id="btn-add-station" class="btn"><i class="fas fa-plus-circle"></i> Estação</button>
                <button id="btn-start-route" class="btn btn-warning"><i class="fas fa-route"></i> Nova Rota</button>
            </div>

            <div class="control-group">
                <button id="btn-edit-mode" class="btn"><i class="fas fa-edit"></i> Editar</button>
                <button id="btn-save" class="btn btn-success"><i class="fas fa-save"></i> Salvar</button>
            </div>

            <div class="instructions">
                <p><strong>Como criar uma rota:</strong></p>
                <ol>
                    <li>Clique em "Nova Rota"</li>
                    <li>Selecione as estações no mapa na ordem desejada</li>
                    <li>Clique em "Finalizar Rota" quando terminar</li>
                </ol>
            </div>

            <div class="station-list">
                <h3 class="section-title"><i class="fas fa-map-marker-alt"></i> Estações</h3>
                <div id="stations-container"></div>
            </div>

            <div class="route-list">
                <h3 class="section-title"><i class="fas fa-train"></i> Rotas</h3>
                <div id="routes-container"></div>
            </div>
        </div>

        <div class="main-content">
            <div class="toolbar">
                <h2>Monitoramento de Cargas</h2>
                <div>
                    <span id="mode-indicator" class="mode-indicator">Modo Visualização</span>
                </div>
            </div>
            <div id="map"></div>
            <div class="status-bar">
                <span id="status-message">Sistema de gerenciamento de rotas ferroviárias</span>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar/editar estação -->
    <div id="station-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title"><i class="fas fa-train-station"></i> Adicionar Estação</h3>
                <span class="close">&times;</span>
            </div>
            <form id="station-form">
                <input type="hidden" id="station-id">
                <div class="form-group">
                    <label for="station-name">Nome da Estação:</label>
                    <input type="text" id="station-name" required>
                </div>
                <div class="form-group">
                    <label for="station-address">Endereço:</label>
                    <input type="text" id="station-address">
                </div>
                <div class="form-group">
                    <label for="station-lat">Latitude:</label>
                    <input type="text" id="station-lat" required>
                </div>
                <div class="form-group">
                    <label for="station-lng">Longitude:</label>
                    <input type="text" id="station-lng" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Salvar Estação</button>
                    <button type="button" class="btn btn-danger" id="btn-delete-station"><i class="fas fa-trash"></i> Excluir Estação</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Painel de criação de rotas -->
    <div id="route-creator" class="route-creator">
        <h3><i class="fas fa-route"></i> Criando Nova Rota</h3>
        <p>Clique nas estações para adicioná-las à rota</p>
        <div class="form-group">
            <label for="route-name">Nome da Rota:</label>
            <input type="text" id="route-name" placeholder="Ex: Rota Sul-Norte">
        </div>
        <div class="control-group">
            <button id="btn-finish-route" class="btn btn-success"><i class="fas fa-check"></i> Finalizar Rota</button>
            <button id="btn-cancel-route" class="btn btn-danger"><i class="fas fa-times"></i> Cancelar</button>
        </div>
        <div id="route-stations-list" style="margin-top: 15px; max-height: 150px; overflow-y: auto;"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Variáveis globais
        let map;
        let stations = [];
        let routes = [];
        let stationMarkers = [];
        let routeLines = [];
        let editMode = false;
        let selectedStation = null;
        let tempMarker = null;
        let creatingRoute = false;
        let currentRoute = [];
        let currentRouteLine = null;

        // Inicialização do mapa
        function initMap() {
            // Coordenadas do centro do Brasil
            const centerLat = -14.2350;
            const centerLng = -51.9253;

            // Criar o mapa
            map = L.map('map').setView([centerLat, centerLng], 5);

            // Adicionar camada do mapa
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Carregar dados do servidor
            loadStations();
            loadRoutes();

            // Evento de clique no mapa
            map.on('click', function(e) {
                if (editMode && !tempMarker && !creatingRoute) {
                    createTempStation(e.latlng);
                }
            });
        }

        // Carregar estações do servidor
        function loadStations() {
            fetch('api.php?action=get_stations')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    stations = data;
                    renderStations();
                    updateStatus("Estações carregadas com sucesso");
                })
                .catch(error => {
                    console.error('Erro ao carregar estações:', error);
                    updateStatus("Erro ao carregar estações");
                });
        }

        // Carregar rotas do servidor
        function loadRoutes() {
            fetch('api.php?action=get_routes')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    routes = data;
                    renderRoutes();
                    updateStatus("Rotas carregadas com sucesso");
                })
                .catch(error => {
                    console.error('Erro ao carregar rotas:', error);
                    updateStatus("Erro ao carregar rotas");
                });
        }

        // Criar estação temporária no mapa
        function createTempStation(latlng) {
            tempMarker = L.marker(latlng, {
                draggable: true,
                icon: L.divIcon({
                    className: 'temp-marker',
                    html: '<div style="background-color: #3498db; width: 18px; height: 18px; border-radius: 50%; border: 3px solid white;"></div>',
                    iconSize: [24, 24]
                })
            }).addTo(map);

            // Preencher coordenadas no formulário
            document.getElementById('station-lat').value = latlng.lat.toFixed(6);
            document.getElementById('station-lng').value = latlng.lng.toFixed(6);

            // Abrir modal para adicionar estação
            openStationModal();
        }

        // Renderizar estações no mapa e na lista
        function renderStations() {
            // Limpar marcadores existentes
            stationMarkers.forEach(marker => map.removeLayer(marker));
            stationMarkers = [];

            // Limpar lista de estações
            const container = document.getElementById('stations-container');
            container.innerHTML = '';

            // Adicionar cada estação
            stations.forEach(station => {
                // Criar marcador no mapa
                const marker = L.marker([station.latitude, station.longitude], {
                    draggable: editMode,
                    icon: L.divIcon({
                        className: 'station-marker',
                        html: '<div style="background-color: #e74c3c; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white;"></div>',
                        iconSize: [26, 26]
                    })
                }).addTo(map);

                // Adicionar popup com informações
                marker.bindPopup(`
                    <div>
                        <h3>${station.nome}</h3>
                        <p>${station.endereco || 'Sem endereço'}</p>
                        <button onclick="editStation(${station.id})" class="btn" style="margin-top: 10px;">Editar</button>
                    </div>
                `);

                // Evento de arrastar (apenas no modo edição)
                if (editMode) {
                    marker.on('dragend', function(e) {
                        const newLat = e.target.getLatLng().lat;
                        const newLng = e.target.getLatLng().lng;
                        updateStationPosition(station.id, newLat, newLng);
                    });
                }

                // Evento de clique
                marker.on('click', function() {
                    if (creatingRoute) {
                        addStationToRoute(station);
                    } else if (editMode) {
                        selectStation(station.id);
                    } else {
                        map.setView([station.latitude, station.longitude], 10);
                        marker.openPopup();
                    }
                });

                stationMarkers.push(marker);

                // Adicionar à lista lateral
                const stationItem = document.createElement('div');
                stationItem.className = 'station-item';
                stationItem.innerHTML = `
                    <strong>${station.nome}</strong>
                    <div style="font-size: 12px; margin-top: 5px;">${station.endereco || ''}</div>
                `;
                stationItem.dataset.id = station.id;

                stationItem.addEventListener('click', function() {
                    if (creatingRoute) {
                        addStationToRoute(station);
                    } else if (editMode) {
                        selectStation(station.id);
                    } else {
                        map.setView([station.latitude, station.longitude], 10);
                        marker.openPopup();
                    }
                });

                container.appendChild(stationItem);
            });
        }

        // Renderizar rotas no mapa
        function renderRoutes() {
            // Limpar rotas existentes
            routeLines.forEach(line => map.removeLayer(line));
            routeLines = [];

            // Limpar lista de rotas
            const container = document.getElementById('routes-container');
            container.innerHTML = '';

            // Adicionar cada rota
            routes.forEach(route => {
                // Obter coordenadas das estações da rota
                const coordinates = [];
                route.estacoes.forEach(estacao => {
                    coordinates.push([estacao.latitude, estacao.longitude]);
                });

                if (coordinates.length > 1) {
                    // Criar linha da rota com estilo de trilho
                    const line = L.polyline(coordinates, {
                        color: '#333',
                        weight: 6,
                        opacity: 0.8,
                        dashArray: '10, 10'
                    }).addTo(map);

                    // Linha de sombra para efeito de trilho
                    const shadowLine = L.polyline(coordinates, {
                        color: '#e74c3c',
                        weight: 8,
                        opacity: 0.3
                    }).addTo(map);

                    // Adicionar popup com informações
                    line.bindPopup(`
                        <div>
                            <h3>${route.nome}</h3>
                            <p>Distância: ${route.distancia_km} km</p>
                            <p>Tempo estimado: ${route.tempo_estimado_min} min</p>
                            <p>Estações: ${route.estacoes.length}</p>
                            <button onclick="deleteRoute(${route.id})" class="btn btn-danger" style="margin-top: 10px;">Excluir Rota</button>
                        </div>
                    `);

                    routeLines.push(line);
                    routeLines.push(shadowLine);

                    // Adicionar à lista lateral
                    const routeItem = document.createElement('div');
                    routeItem.className = 'route-item';
                    routeItem.innerHTML = `
                        <strong>${route.nome}</strong>
                        <div style="font-size: 12px; margin-top: 5px;">
                            Distância: ${route.distancia_km} km | 
                            Tempo: ${Math.floor(route.tempo_estimado_min / 60)}h ${route.tempo_estimado_min % 60}min
                        </div>
                        <div style="font-size: 11px; margin-top: 3px;">
                            ${route.estacoes.length} estações
                        </div>
                    `;

                    routeItem.addEventListener('click', function() {
                        if (coordinates.length > 0) {
                            map.fitBounds(coordinates);
                        }
                    });

                    container.appendChild(routeItem);
                }
            });
        }

        // Alternar modo de edição
        function toggleEditMode() {
            editMode = !editMode;

            const indicator = document.getElementById('mode-indicator');
            const btn = document.getElementById('btn-edit-mode');

            if (editMode) {
                indicator.textContent = 'Modo Edição';
                indicator.style.backgroundColor = '#e74c3c';
                btn.innerHTML = '<i class="fas fa-eye"></i> Visualizar';
                updateStatus("Modo edição ativado - Você pode mover estações");
            } else {
                indicator.textContent = 'Modo Visualização';
                indicator.style.backgroundColor = '#f39c12';
                btn.innerHTML = '<i class="fas fa-edit"></i> Editar';
                updateStatus("Modo visualização ativado");
            }

            renderStations();
        }

        // Iniciar criação de rota
        function startRouteCreation() {
            creatingRoute = true;
            currentRoute = [];

            document.getElementById('route-creator').style.display = 'block';
            updateStatus("Criando nova rota - Clique nas estações para adicioná-las à rota");
            map.getContainer().style.cursor = 'crosshair';
        }

        // Finalizar criação de rota
        function finishRouteCreation() {
            const routeName = document.getElementById('route-name').value || `Rota ${routes.length + 1}`;

            if (currentRoute.length < 2) {
                alert('Uma rota precisa ter pelo menos duas estações');
                return;
            }

            // Preparar dados para envio
            const data = {
                nome: routeName,
                estacoes: JSON.stringify(currentRoute.map(station => station.id))
            };

            // Enviar para o servidor
            fetch('api.php?action=save_route', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        cancelRouteCreation();
                        loadRoutes();
                        updateStatus(`Rota "${routeName}" criada com sucesso`);
                    } else {
                        alert('Erro ao salvar rota: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao salvar rota: ' + error.message);
                });
        }

        // Cancelar criação de rota
        function cancelRouteCreation() {
            creatingRoute = false;
            currentRoute = [];

            document.getElementById('route-creator').style.display = 'none';
            map.getContainer().style.cursor = '';

            if (currentRouteLine) {
                map.removeLayer(currentRouteLine);
                currentRouteLine = null;
            }

            updateStatus("Criação de rota cancelada");
        }

        // Adicionar estação à rota em criação
        function addStationToRoute(station) {
            if (currentRoute.some(s => s.id === station.id)) {
                updateStatus("Esta estação já está na rota");
                return;
            }

            currentRoute.push(station);
            updateRouteStationsList();
            updateTempRouteLine();
            updateStatus(`Estação "${station.nome}" adicionada à rota`);
        }

        // Atualizar lista de estações na rota em criação
        function updateRouteStationsList() {
            const container = document.getElementById('route-stations-list');
            container.innerHTML = '';

            currentRoute.forEach((station, index) => {
                const stationItem = document.createElement('div');
                stationItem.style.padding = '5px';
                stationItem.style.borderBottom = '1px solid #eee';
                stationItem.innerHTML = `${index + 1}. ${station.nome}`;
                container.appendChild(stationItem);
            });
        }

        // Atualizar linha temporária da rota em criação
        function updateTempRouteLine() {
            if (currentRouteLine) {
                map.removeLayer(currentRouteLine);
            }

            if (currentRoute.length > 1) {
                const coordinates = currentRoute.map(station => [station.latitude, station.longitude]);

                currentRouteLine = L.polyline(coordinates, {
                    color: '#3498db',
                    weight: 4,
                    opacity: 0.7,
                    dashArray: '5, 5'
                }).addTo(map);
            }
        }

        // Selecionar estação
        function selectStation(stationId) {
            document.querySelectorAll('.station-item').forEach(item => {
                item.classList.remove('active');
            });

            selectedStation = stationId;

            if (stationId) {
                const stationItem = document.querySelector(`.station-item[data-id="${stationId}"]`);
                if (stationItem) {
                    stationItem.classList.add('active');
                }
            }
        }

        // Abrir modal de estação
        function openStationModal(stationId = null) {
            const modal = document.getElementById('station-modal');
            const title = document.getElementById('modal-title');
            const form = document.getElementById('station-form');
            const deleteBtn = document.getElementById('btn-delete-station');

            if (stationId) {
                title.innerHTML = '<i class="fas fa-train-station"></i> Editar Estação';
                const station = stations.find(s => s.id == stationId);

                if (station) {
                    document.getElementById('station-id').value = station.id;
                    document.getElementById('station-name').value = station.nome;
                    document.getElementById('station-address').value = station.endereco || '';
                    document.getElementById('station-lat').value = station.latitude;
                    document.getElementById('station-lng').value = station.longitude;
                }

                deleteBtn.style.display = 'inline-block';
            } else {
                title.innerHTML = '<i class="fas fa-train-station"></i> Adicionar Estação';
                form.reset();
                document.getElementById('station-id').value = '';
                deleteBtn.style.display = 'none';

                if (!document.getElementById('station-lat').value) {
                    const center = map.getCenter();
                    document.getElementById('station-lat').value = center.lat.toFixed(6);
                    document.getElementById('station-lng').value = center.lng.toFixed(6);
                }
            }

            modal.style.display = 'flex';
        }

        // Editar estação
        function editStation(stationId) {
            openStationModal(stationId);
        }

        // Fechar modais
        function closeModals() {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.style.display = 'none';
            });

            if (tempMarker) {
                map.removeLayer(tempMarker);
                tempMarker = null;
            }
        }

        // Salvar estação
        function saveStation(event) {
            event.preventDefault();

            const data = {
                id: document.getElementById('station-id').value,
                nome: document.getElementById('station-name').value,
                endereco: document.getElementById('station-address').value,
                latitude: document.getElementById('station-lat').value,
                longitude: document.getElementById('station-lng').value
            };

            fetch('api.php?action=save_station', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        closeModals();
                        loadStations();
                        updateStatus(`Estação "${document.getElementById('station-name').value}" salva com sucesso`);
                    } else {
                        alert('Erro ao salvar estação: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao salvar estação: ' + error.message);
                });
        }

        // Excluir estação
        function deleteStation() {
            const stationId = document.getElementById('station-id').value;

            if (!stationId || !confirm('Tem certeza que deseja excluir esta estação?')) {
                return;
            }

            const data = {
                id: stationId
            };

            fetch('api.php?action=delete_station', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        closeModals();
                        loadStations();
                        updateStatus("Estação excluída com sucesso");
                    } else {
                        alert('Erro ao excluir estação: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir estação: ' + error.message);
                });
        }

        // Excluir rota
        function deleteRoute(routeId) {
            if (!confirm('Tem certeza que deseja excluir esta rota?')) {
                return;
            }

            const data = {
                id: routeId
            };

            fetch('api.php?action=delete_route', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        loadRoutes();
                        updateStatus("Rota excluída com sucesso");
                    } else {
                        alert('Erro ao excluir rota: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir rota: ' + error.message);
                });
        }

        // Atualizar posição da estação
        function updateStationPosition(stationId, lat, lng) {
            const data = {
                id: stationId,
                latitude: lat,
                longitude: lng
            };

            fetch('api.php?action=update_station_position', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const station = stations.find(s => s.id == stationId);
                        if (station) {
                            updateStatus(`Posição da estação "${station.nome}" atualizada`);
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
        }

        // Atualizar mensagem de status
        function updateStatus(message) {
            document.getElementById('status-message').textContent = message;
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar mapa
            initMap();

            // Botões
            document.getElementById('btn-add-station').addEventListener('click', function() {
                openStationModal();
            });

            document.getElementById('btn-start-route').addEventListener('click', startRouteCreation);
            document.getElementById('btn-finish-route').addEventListener('click', finishRouteCreation);
            document.getElementById('btn-cancel-route').addEventListener('click', cancelRouteCreation);

            document.getElementById('btn-edit-mode').addEventListener('click', toggleEditMode);

            document.getElementById('btn-save').addEventListener('click', function() {
                // Recarregar dados do servidor
                loadStations();
                loadRoutes();
                updateStatus("Dados atualizados do servidor");
            });

            // Fechar modais
            document.querySelectorAll('.close').forEach(closeBtn => {
                closeBtn.addEventListener('click', closeModals);
            });

            // Formulários
            document.getElementById('station-form').addEventListener('submit', saveStation);
            document.getElementById('btn-delete-station').addEventListener('click', deleteStation);

            // Fechar modal ao clicar fora
            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal')) {
                    closeModals();
                }
            });
        });
    </script>
</body>
<?php
// api.php - Backend para gerenciar estações e rotas

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'trem';
$username = 'root';
$password = 'root';

// Criar conexão MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);

// Verificar conexão
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Erro de conexão: ' . $mysqli->connect_error]);
    exit;
}

// Obter ação da requisição
$action = $_GET['action'] ?? '';

// Para requisições POST, obter os dados do corpo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Se não for JSON, tenta usar POST normal
        $input = $_POST;
    }
} else {
    $input = $_GET;
}

switch ($action) {
    case 'get_stations':
        getStations($mysqli);
        break;

    case 'get_routes':
        getRoutes($mysqli);
        break;

    case 'save_station':
        saveStation($mysqli, $input);
        break;

    case 'delete_station':
        deleteStation($mysqli, $input);
        break;

    case 'save_route':
        saveRoute($mysqli, $input);
        break;

    case 'delete_route':
        deleteRoute($mysqli, $input);
        break;

    case 'update_station_position':
        updateStationPosition($mysqli, $input);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Ação não reconhecida']);
        break;
}

// Função para obter estações
function getStations($mysqli)
{
    try {
        $result = $mysqli->query("SELECT * FROM estacoes ORDER BY nome");
        if ($result) {
            $stations = [];
            while ($row = $result->fetch_assoc()) {
                $stations[] = $row;
            }
            echo json_encode($stations);
        } else {
            throw new Exception($mysqli->error);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao obter estações: ' . $e->getMessage()]);
    }
}

// Função para obter rotas com suas estações
function getRoutes($mysqli)
{
    try {
        // Primeiro, obtemos as rotas
        $result = $mysqli->query("SELECT * FROM rotas ORDER BY nome");
        if (!$result) {
            throw new Exception($mysqli->error);
        }

        $routes = [];
        while ($row = $result->fetch_assoc()) {
            $routes[] = $row;
        }

        // Para cada rota, obtemos suas estações em ordem
        foreach ($routes as &$route) {
            $stmt = $mysqli->prepare("
                SELECT e.* 
                FROM estacoes e 
                JOIN rota_estacoes re ON e.id = re.id_estacao 
                WHERE re.id_rota = ? 
                ORDER BY re.ordem
            ");
            $stmt->bind_param("i", $route['id']);
            $stmt->execute();
            $resultEstacoes = $stmt->get_result();

            $route['estacoes'] = [];
            while ($estacao = $resultEstacoes->fetch_assoc()) {
                $route['estacoes'][] = $estacao;
            }
            $stmt->close();
        }

        echo json_encode($routes);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao obter rotas: ' . $e->getMessage()]);
    }
}

// Função para salvar estação
function saveStation($mysqli, $input)
{
    try {
        $id = $input['id'] ?? null;
        $nome = $input['nome'] ?? '';
        $endereco = $input['endereco'] ?? '';
        $latitude = $input['latitude'] ?? 0;
        $longitude = $input['longitude'] ?? 0;

        if (empty($nome) || empty($latitude) || empty($longitude)) {
            echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
            return;
        }

        if ($id) {
            // Atualizar estação existente
            $stmt = $mysqli->prepare("
                UPDATE estacoes 
                SET nome = ?, endereco = ?, latitude = ?, longitude = ? 
                WHERE id = ?
            ");
            $stmt->bind_param("ssddi", $nome, $endereco, $latitude, $longitude, $id);
        } else {
            // Inserir nova estação
            $stmt = $mysqli->prepare("
                INSERT INTO estacoes (nome, endereco, latitude, longitude) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("ssdd", $nome, $endereco, $latitude, $longitude);
        }

        if ($stmt->execute()) {
            $newId = $id ?: $mysqli->insert_id;
            echo json_encode(['success' => true, 'id' => $newId]);
        } else {
            throw new Exception($stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar estação: ' . $e->getMessage()]);
    }
}

// Função para excluir estação
function deleteStation($mysqli, $input)
{
    try {
        $id = $input['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
            return;
        }

        // Verificar se a estação está sendo usada em alguma rota
        $stmt = $mysqli->prepare("
            SELECT COUNT(*) as count 
            FROM rota_estacoes 
            WHERE id_estacao = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row['count'] > 0) {
            echo json_encode(['success' => false, 'message' => 'Não é possível excluir a estação pois ela está sendo usada em uma ou mais rotas']);
            return;
        }

        // Excluir estação
        $stmt = $mysqli->prepare("DELETE FROM estacoes WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception($stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir estação: ' . $e->getMessage()]);
    }
}

// Função para salvar rota
function saveRoute($mysqli, $input)
{
    try {
        $nome = $input['nome'] ?? '';
        $estacoes_json = $input['estacoes'] ?? '[]';

        // Decodificar o JSON das estações
        $estacoes = json_decode($estacoes_json, true);

        if (empty($nome) || !is_array($estacoes) || count($estacoes) < 2) {
            echo json_encode(['success' => false, 'message' => 'Dados incompletos: nome e pelo menos duas estações são obrigatórios']);
            return;
        }

        // Calcular distância total
        $distancia_total = 0;
        $stmt = $mysqli->prepare("SELECT latitude, longitude FROM estacoes WHERE id = ?");

        for ($i = 0; $i < count($estacoes) - 1; $i++) {
            $stmt->bind_param("i", $estacoes[$i]);
            $stmt->execute();
            $estacao1 = $stmt->get_result()->fetch_assoc();

            $stmt->bind_param("i", $estacoes[$i + 1]);
            $stmt->execute();
            $estacao2 = $stmt->get_result()->fetch_assoc();

            if ($estacao1 && $estacao2) {
                // Fórmula de Haversine para calcular distância
                $lat1 = deg2rad($estacao1['latitude']);
                $lon1 = deg2rad($estacao1['longitude']);
                $lat2 = deg2rad($estacao2['latitude']);
                $lon2 = deg2rad($estacao2['longitude']);

                $dlat = $lat2 - $lat1;
                $dlon = $lon2 - $lon1;

                $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $distancia = 6371 * $c; // Raio da Terra em km

                $distancia_total += $distancia;
            }
        }
        $stmt->close();

        // Calcular tempo estimado (60 km/h em média)
        $tempo_estimado = round(($distancia_total / 60) * 60);

        $mysqli->begin_transaction();

        // Inserir rota
        $stmt = $mysqli->prepare("INSERT INTO rotas (nome, distancia_km, tempo_estimado_min) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nome, round($distancia_total, 2), $tempo_estimado);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $id_rota = $mysqli->insert_id;
        $stmt->close();

        // Inserir estações da rota
        $stmt = $mysqli->prepare("INSERT INTO rota_estacoes (id_rota, id_estacao, ordem) VALUES (?, ?, ?)");

        foreach ($estacoes as $index => $id_estacao) {
            $stmt->bind_param("iii", $id_rota, $id_estacao, $index);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
        }

        $stmt->close();
        $mysqli->commit();

        echo json_encode(['success' => true, 'id' => $id_rota]);
    } catch (Exception $e) {
        $mysqli->rollback();
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar rota: ' . $e->getMessage()]);
    }
}

// Função para excluir rota
function deleteRoute($mysqli, $input)
{
    try {
        $id = $input['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
            return;
        }

        // Excluir rota (as rota_estacoes serão excluídas em cascade)
        $stmt = $mysqli->prepare("DELETE FROM rotas WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception($stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir rota: ' . $e->getMessage()]);
    }
}

// Função para atualizar posição da estação
function updateStationPosition($mysqli, $input)
{
    try {
        $id = $input['id'] ?? null;
        $latitude = $input['latitude'] ?? 0;
        $longitude = $input['longitude'] ?? 0;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID não fornecido']);
            return;
        }

        $stmt = $mysqli->prepare("UPDATE estacoes SET latitude = ?, longitude = ? WHERE id = ?");
        $stmt->bind_param("ddi", $latitude, $longitude, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception($stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar posição: ' . $e->getMessage()]);
    }
}

// Fechar conexão
$mysqli->close();
?>

</html>