<?php
require_once '../../db/conn.php';

session_start(); // Inicia a sessão

$error = "";

// Coleta e sanitiza os dados do formulário
$tipocarga = trim($_POST["tipocarga"] ?? "");
$tamanhocarga = trim($_POST["tamanhocarga"] ?? "");
$dataIda = trim($_POST["dataIda"] ?? "");
$dataVolta = trim($_POST["dataVolta"] ?? "");
$observacoes = trim($_POST["observacoes"] ?? ""); // Corrigido: o campo deve ter o mesmo nome do form

// Verifica se os campos obrigatórios estão preenchidos
if (empty($tipocarga) || empty($tamanhocarga) || empty($dataIda)) {
    $error = "Preencha todos os campos obrigatórios.";
} else {
    // Prepara a query
    $stmt = $conn->prepare("
        INSERT INTO sensores (tipo_sensor, localizacao_sensor, data_sensor, data_sensor_volta, observacao_sensor)
        VALUES (?, ?, ?, ?, ?)
    ");

    if ($stmt) {
        $stmt->bind_param("sssss", $tipocarga, $tamanhocarga, $dataIda, $dataVolta, $observacoes);

        if ($stmt->execute()) {
            header("Location: ../gerenciamento_sensores.php");
            exit;
        } else {
            $error = "Erro ao cadastrar carga: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        $error = "Erro ao preparar a consulta: " . htmlspecialchars($conn->error);
    }
}

if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
