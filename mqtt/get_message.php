<?php
require("phpMQTT.php");

$server = "test.mosquitto.org";
$port = 8883;
$topic = "Trem/Vel";
$client_id = "SMARTTRAIN-" . rand();

$username = "SMARTTRAIN_TREM";
$password = "SmartTrain2025";

// Se for uma requisição AJAX (fetch), retorna as mensagens em JSON
if (isset($_GET['fetch'])) {
    header('Content-Type: application/json');

    $messages = [];

    $mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
    if (!$mqtt->connect(true, NULL, $username, $password)) {
        echo json_encode(["error" => "Não foi possível conectar ao broker"]);
        exit;
    }

    // Subscreve e coleta mensagens por 2 segundos
    $mqtt->subscribe([
        $topic => [
            "qos" => 0,
            "function" => function ($topic, $msg) use (&$messages) {
                $messages[] = ["topic" => $topic, "msg" => $msg, "time" => date("H:i:s")];
            }
        ]
    ], 0);

    $start = time();
    while (time() - $start < 2) {
        $mqtt->proc();
    }

    $mqtt->close();

    echo json_encode($messages);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>MQTT Dashboard PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0e1116;
            color: #f2f2f2;
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #00c3ff;
        }
        #messages {
            background: #1a1f29;
            border-radius: 8px;
            padding: 15px;
            margin: 20px auto;
            width: 90%;
            max-width: 600px;
            height: 300px;
            overflow-y: auto;
            text-align: left;
        }
        .msg {
            padding: 5px;
            border-bottom: 1px solid #333;
            font-family: monospace;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 60%;
            border: none;
            border-radius: 6px;
            outline: none;
        }
        button {
            padding: 10px 20px;
            background-color: #00c3ff;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #008dbb;
        }
    </style>

    <script>
        let allMessages = [];

        function fetchMessages() {
            fetch('?fetch=1')
                .then(res => res.json())
                .then(messages => {
                    messages.forEach(m => {
                        const key = m.time + m.msg;
                        if (!allMessages.find(existing => existing.time + existing.msg === key)) {
                            allMessages.push(m);
                            const div = document.createElement('div');
                            div.className = 'msg';
                            div.textContent = `[${m.time}] ${m.msg}`;
                            document.getElementById('messages').appendChild(div);
                            document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
                        }
                    });
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
</body>
</html>
