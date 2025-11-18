<?php
require("phpMQTT.php");

$server = "test.mosquitto.org";
$port = 1883;
$topic = "TESTEIcaroTOP";

// Publicação via formulário
if (isset($_POST['msg']) && !empty($_POST['msg'])) {
    $client_id = "phpmqtt-pub-" . rand();
    $mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
    if ($mqtt->connect(true, NULL, "", "")) {
        $mqtt->publish($topic, $_POST['msg'], 0);
        $mqtt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>MQTT Dashboard PHP</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        #messages {
            border: 1px solid #ccc;
            padding: 10px;
            max-height: 400px;
            overflow: auto;
            margin-bottom: 10px;
        }

        .msg {
            font-family: monospace;
            margin-bottom: 5px;
        }

        form {
            margin-top: 10px;
        }
    </style>
    <script>
        let allMessages = [];

        function fetchMessages() {
            fetch('get_messages.php?t=' + new Date().getTime())
                .then(r => r.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    if (data.length > 0) {
                        data.forEach(m => {
                            const key = m.time + m.msg;
                            if (!allMessages.includes(key)) {
                                allMessages.push(key);
                                const div = document.createElement('div');
                                div.className = 'msg';
                                div.textContent = `[${m.time}] ${m.topic}: ${m.msg}`;
                                document.getElementById('messages').appendChild(div);
                            }
                        });
                    }
                })
                .catch(e => console.error(e));
        }

        // Polling a cada 1 segundo
        setInterval(fetchMessages, 1000);
        fetchMessages();
    </script>
</head>

<body>
    <h1>Mensagens MQTT (TESTEIcaroTOP)</h1>
    <div id="messages"></div>

    <form method="post">
        <inpu