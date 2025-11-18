<?php
/**
 * Configuração do MQTT Dashboard
 */

// Configurações do Broker MQTT
define('MQTT_BROKER_HOST', getenv('MQTT_BROKER_HOST') ?: 'test.mosquitto.org');
define('MQTT_BROKER_PORT', getenv('MQTT_BROKER_PORT') ?: 1883);
define('MQTT_USERNAME', getenv('MQTT_USERNAME') ?: '');
define('MQTT_PASSWORD', getenv('MQTT_PASSWORD') ?: '');

// Configurações da Aplicação
define('APP_TITLE', 'MQTT Dashboard');
define('APP_VERSION', '1.0.0');

// Arquivo de cache para dados dos sensores e atuadores
define('CACHE_FILE', __DIR__ . '/data/cache.json');
define('CACHE_DIR', __DIR__ . '/data');

// Criar diretório de cache se não existir
if (!is_dir(CACHE_DIR)) {
    mkdir(CACHE_DIR, 0755, true);
}

// Inicializar cache se não existir
if (!file_exists(CACHE_FILE)) {
    $initial_data = [
        'sensors' => [],
        'actuators' => [],
        'last_update' => time()
    ];
    file_put_contents(CACHE_FILE, json_encode($initial_data, JSON_PRETTY_PRINT));
}
?>
