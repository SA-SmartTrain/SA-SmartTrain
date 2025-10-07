<?php
require_once __DIR__ . '/../db/conn.php';
session_start();

$error = "";

// Coleta os dados corretamente com os nomes do HTML
$tipocarga   = isset($_POST["carga"]) ? trim($_POST["carga"]) : '';
$tamanhocarga = isset($_POST["tamanho"]) ? trim($_POST["tamanho"]) : '';
$dataIda     = isset($_POST["dataIda"]) ? trim($_POST["dataIda"]) : '';
$observacoes = isset($_POST["observacoes"]) ? trim($_POST["observacoes"]) : '';

// Validação de campos obrigatórios
if ($tipocarga === '' || $tamanhocarga === '' || $dataIda === '' || $observacoes === '') {
    $error = "Preencha todos os campos obrigatórios.";
} else {
    if (!$conn) {
        die("Erro de conexão com o banco de dados.");
    }

    // Query correta com 4 parâmetros
    $stmt = $conn->prepare("
        INSERT INTO sensores 
        (tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor)
        VALUES (?, ?, ?, ?)
    ");

    if ($stmt) {
        $stmt->bind_param("ssss", $tipocarga, $tamanhocarga, $dataIda, $observacoes);

        if ($stmt->execute()) {
            header("Location: ../public/gerenciamento_sensores.php");
            exit;
        } else {
            $error = "Erro ao cadastrar sensor: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        $error = "Erro ao preparar a consulta: " . htmlspecialchars($conn->error);
    }
}

// Mostra erro se houver
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
