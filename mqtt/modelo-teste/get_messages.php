<?php
require("phpMQTT.php");

$server = "test.mosquitto.org";
$port = 1883;
$topic = "TESTEIcaroTOP";
$client_id = "phpmqtt-" . rand();

$username = "";
$password = "";

header('Content-Type: application/json');

$messages = [];

$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
if (!$mqtt->connect(true, NULL, $username, $password)) {
    echo json_encode(["error" => "Não foi possível conectar ao broker"]);
    exit;
}

// Subscribing e coletando mensagens por 1-2 segundos
$mqtt->subscribe([$topic => ["qos" => 0, "function" => function ($topic, $msg) use (&$messages) {
    $messages[] = ["topic" => $topic, "msg" => $msg, "time" => date("H:i:s")];
}]], 0);

$start = time();
while (time() - $start < 2) { // escuta 2 segundos
    $mqtt->proc();
}

$mqtt->close();

echo json_encode($messages);
