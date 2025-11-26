<?php
// admin_panel.php - Painel de Controle Dinâmico para Sensores ESP32/HiveMQ
// O PHP é usado apenas para servir a página. O CSS e o JS estão embutidos.

// NOTA: Para um ambiente de produção, o código PHP seria usado para:
// 1. Autenticação e Autorização do Administrador.
// 2. Configurações dinâmicas (ex: endereço do broker MQTT).
// 3. Persistência de dados (ex: salvar histórico de ativações em um banco de dados).
// Neste exemplo, focamos na estrutura solicitada (PHP com CSS/JS embutidos).
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/SA-SmartTrain/src/assets/logo/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartTrain - Visualizar Sensores MQTT Ativos</title>

    <!-- CSS EMBUTIDO -->
    <style>
        :root {
            --cor-fundo: #f4f7f6;
            --cor-primaria: rgb(242, 211, 124);
            ;
            --cor-sucesso: #28a745;
            --cor-alerta: #dc3545;
            --cor-inativo: #6c757d;
            --cor-texto: #343a40;
            --cor-card: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: var(--cor-texto);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #2C2C2C;
            font-size: 26px;
            position: relative;
            right: 320px;
            top: 30px;
            text-decoration: none;
        }

        a {
            text-decoration: none;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            /* Mapa e Status */
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: var(--cor-card);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        /* --- SEÇÃO A: MAPA DE SENSORES --- */
        .mapa-sensores {
            text-align: center;
            position: relative;
            height: 300px;
            /* Altura fixa para o mapa */
        }

        .mapa-sensores h2 {
            margin-top: 0;
            color: var(--cor-primaria);
        }

        .trilho {
            width: 80%;
            height: 100px;
            border: 5px solid var(--cor-inativo);
            border-radius: 50px;
            margin: 50px auto 0;
            position: relative;
        }

        .sensor-indicator {
            position: absolute;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--cor-inativo);
            border: 3px solid var(--cor-card);
            line-height: 34px;
            font-weight: bold;
            color: var(--cor-card);
            transition: background-color 0.3s ease;
            cursor: help;
        }

        .sensor-indicator.ativo {
            background-color: var(--cor-sucesso);
            box-shadow: 0 0 15px var(--cor-sucesso);
        }

        /* Posições dos Sensores no Mapa (Ajustar conforme o layout real) */
        #mapa-s1 {
            top: 80px;
            left: 10%;
        }

        #mapa-s2 {
            top: 0px;
            left: 45%;
        }

        #mapa-s3 {
            top: 80px;
            right: 10%;
        }

        /* --- SEÇÃO B & C: TABELAS DE STATUS --- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: var(--cor-primaria);
            color: var(--cor-card);
            font-weight: 600;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .status-dot {
            height: 12px;
            width: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-online {
            background-color: var(--cor-sucesso);
        }

        .status-offline {
            background-color: var(--cor-alerta);
        }

        .status-ativado {
            background-color: var(--cor-sucesso);
        }

        .status-desativado {
            background-color: var(--cor-inativo);
        }

        .alerta-conexao {
            padding: 10px;
            background-color: var(--cor-alerta);
            color: var(--cor-card);
            border-radius: 5px;
            margin-bottom: 15px;
            display: none;
            /* Escondido por padrão */
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="../public/admin/admin.php">
            <h1>Visualizar Sensores MQTT Ativos</h1>
        </a>
        <!--
        <div id="mqtt-status" class="alerta-conexao">
            Status da Conexão MQTT: Desconectado. Tentando reconectar...
        </div>
    -->
        <div class="container-down" style="position: relative; top: 50px;">
            <div class="dashboard-grid">
                <!-- SEÇÃO A: MAPA DE SENSORES -->
                <div class="card">
                    <h2>Mapa de Sensores</h2>
                    <div class="mapa-sensores">
                        <div class="trilho">
                            <div id="mapa-s1" class="sensor-indicator" title="Sensor S1">S1</div>
                            <div id="mapa-s2" class="sensor-indicator" title="Sensor S2">S2</div>
                            <div id="mapa-s3" class="sensor-indicator" title="Sensor S3">S3</div>
                            <div id="mapa-s4" class="sensor-indicator" title="Sensor S4">
                                Trem
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEÇÃO B: STATUS DOS SENSORES -->
                <div class="card">
                    <h2>Status Detalhado dos Sensores</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Sensor</th>
                                <th>Status</th>
                                <th>Última Ativação</th>
                            </tr>
                        </thead>
                        <tbody id="tabela-sensores">
                            <tr id="linha-s1">
                                <td>S1 (Placa No. 1)</td>
                                <td><span class="status-dot status-desativado" id="dot-s1"></span><span id="status-s1">Desativado</span></td>
                                <td id="time-s1">--</td>
                            </tr>
                            <tr id="linha-s2">
                                <td>S2 (Placa No. 2)</td>
                                <td><span class="status-dot status-desativado" id="dot-s2"></span><span id="status-s2">Desativado</span></td>
                                <td id="time-s2">--</td>
                            </tr>
                            <tr id="linha-s3">
                                <td>S3 (Placa No. 3)</td>
                                <td><span class="status-dot status-desativado" id="dot-s3"></span><span id="status-s3">Desativado</span></td>
                                <td id="time-s3">--</td>
                            </tr>
                            <tr id="linha-s4">
                                <td>S3 (Trem No. 4)</td>
                                <td><span class="status-dot status-desativado" id="dot-s3"></span><span id="status-s3">Desativado</span></td>
                                <td id="time-s3">--</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SEÇÃO C: STATUS DAS PLACAS ESP32 -->
            <div class="card">
                <h2>Status das Placas ESP32 (Conexão)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Status</th>
                            <th>RSSI (Força do Sinal)</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-placas">
                        <tr id="placa-no2">
                            <td>(S2)</td>
                            <td><span class="status-dot status-offline" id="dot-placa-no2"></span><span id="status-placa-no2">Offline</span></td>
                            <td id="rssi-placa-no2">--</td>
                        </tr>
                        <tr id="placa-no3">
                            <td>(S3)</td>
                            <td><span class="status-dot status-offline" id="dot-placa-no3"></span><span id="status-placa-no3">Offline</span></td>
                            <td id="rssi-placa-no3">--</td>
                        </tr>
                        <tr id="placa-estacao">
                            <td>(S1)</td>
                            <td><span class="status-dot status-offline" id="dot-placa-estacao"></span><span id="status-placa-estacao">Offline</span></td>
                            <td id="rssi-placa-estacao">--</td>
                        </tr>
                        <tr id="placa-trem">
                            <td>Trem (S4)</td>
                            <td><span class="status-dot status-offline" id="dot-placa-trem"></span><span id="status-placa-trem">Offline</span></td>
                            <td id="rssi-placa-trem">--</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- JAVASCRIPT EMBUTIDO -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script>
        // Configurações MQTT
        const HOST = 'seu.33729ac4982c466e929cf9c5c431c8c8.s1.eu.hivemq.cloud.hivemq.com'; // Substitua pelo endereço do seu broker HiveMQ
        const PORT = 8883; // Porta WebSocket (geralmente 8083 ou 8084 para SSL)
        const CLIENT_ID = 'SMARTTRAIN_TREM_ADMIN_' + Math.random().toString(16).substr(2, 8);

        // Tópicos de Inscrição
        const TOPICOS_SENSORES = ['trem/sensor/S1', 'trem/sensor/S2', 'trem/sensor/S3'];
        const TOPICOS_PLACAS = ['Trem/Vel', 'trem/placa/No3', 'trem/placa/Estacao', 'trem/placa/Trem'];

        let client;

        // Função para formatar o timestamp
        function formatTime(timestamp) {
            if (timestamp === '--') return '--';
            const date = new Date(timestamp * 1000);
            return date.toLocaleTimeString('pt-BR') + ' ' + date.toLocaleDateString('pt-BR');
        }

        // --- Funções de Atualização da UI ---

        function updateSensorStatus(sensorId, status, timestamp) {
            const isAtivo = status === 'ativado';
            const statusText = isAtivo ? 'ATIVADO' : 'Desativado';
            const statusClass = isAtivo ? 'ativo' : 'desativado';
            const timeText = isAtivo ? formatTime(timestamp) : '--';

            // 1. Atualiza o Mapa
            const mapaIndicator = document.getElementById(`mapa-${sensorId.toLowerCase()}`);
            if (mapaIndicator) {
                mapaIndicator.classList.remove('ativo');
                if (isAtivo) {
                    mapaIndicator.classList.add('ativo');
                }
            }

            // 2. Atualiza a Tabela
            document.getElementById(`status-${sensorId.toLowerCase()}`).textContent = statusText;
            document.getElementById(`time-${sensorId.toLowerCase()}`).textContent = timeText;

            const dot = document.getElementById(`dot-${sensorId.toLowerCase()}`);
            dot.className = `status-dot status-${statusClass}`;
        }

        function updatePlacaStatus(placaId, online, rssi) {
            const statusText = online ? 'Online' : 'Offline';
            const statusClass = online ? 'online' : 'offline';
            const rssiText = online ? `${rssi} dBm` : '--';

            document.getElementById(`status-placa-${placaId.toLowerCase()}`).textContent = statusText;
            document.getElementById(`rssi-placa-${placaId.toLowerCase()}`).textContent = rssiText;

            const dot = document.getElementById(`dot-placa-${placaId.toLowerCase()}`);
            dot.className = `status-dot status-${statusClass}`;
        }

        // --- Funções de Conexão MQTT ---

        function onConnect() {
            console.log("Conectado ao Broker MQTT.");
            document.getElementById('mqtt-status').style.display = 'none';

            // Inscreve-se em todos os tópicos
            TOPICOS_SENSORES.forEach(topic => client.subscribe(topic));
            TOPICOS_PLACAS.forEach(topic => client.subscribe(topic));
        }

        function onConnectionLost(responseObject) {
            if (responseObject.errorCode !== 0) {
                console.log("Conexão MQTT Perdida: " + responseObject.errorMessage);
                document.getElementById('mqtt-status').style.display = 'block';
                setTimeout(connectMQTT, 5000); // Tenta reconectar após 5 segundos
            }
        }

        function onMessageArrived(message) {
            console.log(`Mensagem recebida no tópico ${message.destinationName}: ${message.payloadString}`);

            try {
                const payload = JSON.parse(message.payloadString);
                const topic = message.destinationName;

                // Atualiza Status do Sensor
                if (topic.startsWith('trem/sensor/')) {
                    const sensorId = topic.split('/').pop(); // Ex: S1, S2, S3
                    updateSensorStatus(sensorId, payload.status, payload.timestamp);
                }
                // Atualiza Status da Placa
                else if (topic.startsWith('trem/placa/')) {
                    const placaId = topic.split('/').pop(); // Ex: No2, No3, Estacao, Trem
                    updatePlacaStatus(placaId, payload.online, payload.rssi);
                }

            } catch (e) {
                console.error("Erro ao processar payload JSON:", e);
            }
        }

        function connectMQTT() {
            document.getElementById('mqtt-status').style.display = 'block';
            client = new Paho.MQTT.Client(HOST, PORT, CLIENT_ID);

            client.onConnectionLost = onConnectionLost;
            client.onMessageArrived = onMessageArrived;

            const options = {
                timeout: 3,
                onSuccess: onConnect,
                onFailure: (message) => {
                    console.log("Falha na Conexão MQTT: " + message.errorMessage);
                    setTimeout(connectMQTT, 5000);
                }
            };

            client.connect(options);
        }

        // Inicia a conexão quando a página carrega
        window.onload = connectMQTT;

        // --- SIMULAÇÃO DE DADOS (Para testes sem um broker real) ---
        // Remova esta seção em produção
        let mockData = {
            'trem/sensor/S1': {
                status: 'ativado',
                timestamp: 0
            },
            'trem/sensor/S2': {
                status: 'desativado',
                timestamp: 0
            },
            'trem/sensor/S3': {
                status: 'desativado',
                timestamp: 0
            },
            'trem/placa/No2': {
                online: false,
                rssi: 0
            },
            'trem/placa/No3': {
                online: false,
                rssi: 0
            },
            'trem/placa/Estacao': {
                online: false,
                rssi: 0
            },
            'trem/placa/Trem': {
                online: false,
                rssi: 0
            }
        };

        function simulateMQTT() {
            // Simula a ativação de um sensor
            const sensors = ['S1', 'S2', 'S3'];
            const randomSensor = sensors[Math.floor(Math.random() * sensors.length)];
            const isActivated = Math.random() > 0.7; // 30% de chance de ativar

            if (isActivated) {
                mockData[`trem/sensor/${randomSensor}`] = {
                    status: 'ativado',
                    timestamp: Math.floor(Date.now() / 1000)
                };
            } else {
                // Se não ativou, verifica se algum estava ativo para desativar
                for (let key in mockData) {
                    if (key.startsWith('trem/sensor/') && mockData[key].status === 'ativado') {
                        mockData[key] = {
                            status: 'desativado',
                            timestamp: mockData[key].timestamp
                        };
                    }
                }
            }

            // Simula o status das placas
            const placas = ['No2', 'No3', 'Estacao', 'Trem'];
            placas.forEach(placa => {
                const isOnline = Math.random() > 0.1; // 90% de chance de estar online
                mockData[`trem/placa/${placa}`] = {
                    online: isOnline,
                    rssi: isOnline ? Math.floor(Math.random() * (-30) - 30) : 0 // Entre -30 e -60
                };
            });

            // Dispara as atualizações na UI como se fossem mensagens MQTT
            for (const topic in mockData) {
                const payload = JSON.stringify(mockData[topic]);
                onMessageArrived({
                    destinationName: topic,
                    payloadString: payload
                });
            }
        }

        // Inicia a simulação a cada 3 segundos
        // setInterval(simulateMQTT, 3000); 
        // Descomente a linha acima para ver a UI se atualizando automaticamente.
        // Lembre-se de remover a simulação em produção.
    </script>
</body>

</html>