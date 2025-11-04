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
                        if (!allMessages.find(m => m.time + m.msg === key)) {
                                allMessages.push(m);
                                const div = document.createElement('div');
                                div.className = 'msg';
                                div.textContent = `[${m.time}] ${m.msg}`;
                                document.getElementById('messages').appendChild(div);
                            }
                        });
                    }
                })
                .catch(err => console.error('Erro ao buscar mensagens:', err));
        }

        setInterval(fetchMessages, 2000); // busca a cada 2 segundos
        window.onload = fetchMessages;
    </script>
</head>
<body>
    <h1>MQTT Dashboard PHP</h1>
    <div id="messages"></div>

    <form method="post">
        <input type="text" name="msg" placeholder="Digite sua mensagem" required>
        <button type="submit">Enviar</button>
    </form>