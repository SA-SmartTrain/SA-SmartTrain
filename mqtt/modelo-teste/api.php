<?php
require_once 'config.php';
require_once 'phpMQTT.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$response = ['success' => false, 'message' => ''];

try {
    switch ($action) {
        case 'get_sensors':
            $response = getSensors();
            break;

        case 'get_actuators':
            $response = getActuators();
            break;

        case 'control_actuator':
            $response = controlActuator(
                $_POST['actuator_id'] ?? null,
                $_POST['command'] ?? null
            );
            break;

        case 'add_sensor':
            $response = addSensor(
                $_POST['name'] ?? '',
                $_POST['topic'] ?? '',
                $_POST['type'] ?? 'sensor'
            );
            break;

        case 'add_actuator':
            $response = addActuator(
                $_POST['name'] ?? '',
                $_POST['topic'] ?? '',
                $_POST['type'] ?? 'led'
            );
            break;

        case 'delete_sensor':
            $response = deleteSensor($_POST['sensor_id'] ?? null);
            break;

        case 'delete_actuator':
            $response = deleteActuator($_POST['actuator_id'] ?? null);
            break;

        case 'refresh_status':
            $response = refreshStatus();
            break;

        default:
            $response['message'] = 'Ação inválida';
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);

/**
 * Obter lista de sensores do cache
 */
function getSensors() {
    $data = getCache();
    return [
        'success' => true,
        'sensors' => $data['sensors'] ?? []
    ];
}

/**
 * Obter lista de atuadores do cache
 */
function getActuators() {
    $data = getCache();
    return [
        'success' => true,
        'actuators' => $data['actuators'] ?? []
    ];
}

/**
 * Controlar um atuador (ligar/desligar)
 */
function controlActuator($actuator_id, $command) {
    if (!$actuator_id || !in_array($command, ['on', 'off'])) {
        return ['success' => false, 'message' => 'Parâmetros inválidos'];
    }

    $data = getCache();
    $actuators = $data['actuators'] ?? [];

    // Encontrar o atuador
    $actuator = null;
    foreach ($actuators as &$act) {
        if ($act['id'] == $actuator_id) {
            $actuator = &$act;
            break;
        }
    }

    if (!$actuator) {
        return ['success' => false, 'message' => 'Atuador não encontrado'];
    }

    // Conectar ao broker MQTT e publicar comando
    try {
        $mqtt = new \Bluerhinos\phpMQTT(MQTT_BROKER_HOST, MQTT_BROKER_PORT, 'mqtt-dashboard-' . time());
        
        if ($mqtt->connect(true, null, MQTT_USERNAME, MQTT_PASSWORD)) {
            // Publicar comando (1 para on, 0 para off)
            $payload = ($command === 'on') ? '1' : '0';
            $mqtt->publish($actuator['topic'], $payload, 0);
            $mqtt->close();

            // Atualizar status no cache
            $actuator['status'] = $command;
            $actuator['last_updated'] = date('Y-m-d H:i:s');
            saveCache($data);

            return [
                'success' => true,
                'message' => 'Atuador controlado com sucesso',
                'actuator' => $actuator
            ];
        } else {
            return ['success' => false, 'message' => 'Falha ao conectar ao broker MQTT'];
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
    }
}

/**
 * Adicionar um novo sensor
 */
function addSensor($name, $topic, $type) {
    if (!$name || !$topic) {
        return ['success' => false, 'message' => 'Nome e tópico são obrigatórios'];
    }

    $data = getCache();
    $sensors = $data['sensors'] ?? [];

    // Verificar se o tópico já existe
    foreach ($sensors as $sensor) {
        if ($sensor['topic'] === $topic) {
            return ['success' => false, 'message' => 'Tópico já existe'];
        }
    }

    $sensor = [
        'id' => uniqid(),
        'name' => $name,
        'topic' => $topic,
        'type' => $type,
        'status' => 'unknown',
        'last_value' => null,
        'last_updated' => null,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $sensors[] = $sensor;
    $data['sensors'] = $sensors;
    saveCache($data);

    return [
        'success' => true,
        'message' => 'Sensor adicionado com sucesso',
        'sensor' => $sensor
    ];
}

/**
 * Adicionar um novo atuador
 */
function addActuator($name, $topic, $type) {
    if (!$name || !$topic) {
        return ['success' => false, 'message' => 'Nome e tópico são obrigatórios'];
    }

    $data = getCache();
    $actuators = $data['actuators'] ?? [];

    // Verificar se o tópico já existe
    foreach ($actuators as $actuator) {
        if ($actuator['topic'] === $topic) {
            return ['success' => false, 'message' => 'Tópico já existe'];
        }
    }

    $actuator = [
        'id' => uniqid(),
        'name' => $name,
        'topic' => $topic,
        'type' => $type,
        'status' => 'off',
        'last_updated' => null,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $actuators[] = $actuator;
    $data['actuators'] = $actuators;
    saveCache($data);

    return [
        'success' => true,
        'message' => 'Atuador adicionado com sucesso',
        'actuator' => $actuator
    ];
}

/**
 * Deletar um sensor
 */
function deleteSensor($sensor_id) {
    if (!$sensor_id) {
        return ['success' => false, 'message' => 'ID do sensor é obrigatório'];
    }

    $data = getCache();
    $sensors = $data['sensors'] ?? [];

    $data['sensors'] = array_filter($sensors, function ($s) use ($sensor_id) {
        return $s['id'] !== $sensor_id;
    });

    saveCache($data);

    return ['success' => true, 'message' => 'Sensor deletado com sucesso'];
}

/**
 * Deletar um atuador
 */
function deleteActuator($actuator_id) {
    if (!$actuator_id) {
        return ['success' => false, 'message' => 'ID do atuador é obrigatório'];
    }

    $data = getCache();
    $actuators = $data['actuators'] ?? [];

    $data['actuators'] = array_filter($actuators, function ($a) use ($actuator_id) {
        return $a['id'] !== $actuator_id;
    });

    saveCache($data);

    return ['success' => true, 'message' => 'Atuador deletado com sucesso'];
}

/**
 * Atualizar status dos sensores conectando ao broker
 */
function refreshStatus() {
    $data = getCache();
    $messages = [];

    try {
        $mqtt = new \Bluerhinos\phpMQTT(MQTT_BROKER_HOST, MQTT_BROKER_PORT, 'mqtt-dashboard-' . time());
        
        if ($mqtt->connect(true, null, MQTT_USERNAME, MQTT_PASSWORD)) {
            $sensors = $data['sensors'] ?? [];

            // Subscrever a todos os tópicos dos sensores
            $topics = [];
            foreach ($sensors as $sensor) {
                $topics[$sensor['topic']] = ['qos' => 0, 'function' => function ($topic, $msg) use (&$messages) {
                    $messages[$topic] = $msg;
                }];
            }

            if (!empty($topics)) {
                $mqtt->subscribe($topics);

                // Aguardar mensagens por 2 segundos
                $start = time();
                while (time() - $start < 2) {
                    $mqtt->proc();
                    usleep(100000);
                }
            }

            $mqtt->close();

            // Atualizar status dos sensores
            foreach ($sensors as &$sensor) {
                if (isset($messages[$sensor['topic']])) {
                    $value = $messages[$sensor['topic']];
                    $sensor['last_value'] = $value;
                    $sensor['status'] = (strtolower($value) === 'on' || $value === '1') ? 'on' : 'off';
                    $sensor['last_updated'] = date('Y-m-d H:i:s');
                }
            }

            $data['sensors'] = $sensors;
            $data['last_update'] = time();
            saveCache($data);

            return [
                'success' => true,
                'message' => 'Status atualizado com sucesso',
                'messages_received' => count($messages)
            ];
        } else {
            return ['success' => false, 'message' => 'Falha ao conectar ao broker MQTT'];
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Erro: ' . $e->getMessage()];
    }
}

/**
 * Obter dados do cache
 */
function getCache() {
    if (file_exists(CACHE_FILE)) {
        $content = file_get_contents(CACHE_FILE);
        return json_decode($content, true) ?? [];
    }
    return [];
}

/**
 * Salvar dados no cache
 */
function saveCache($data) {
    file_put_contents(CACHE_FILE, json_encode($data, JSON_PRETTY_PRINT));
}
?>
