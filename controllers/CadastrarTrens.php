<?php
require_once __DIR__ . '/../db/conn.php';
session_start();

$error = "";

// Coleta os dados corretamente com os nomes do HTML
$codigo   = isset($_POST["idtrens"]) ? trim($_POST["idtrens"]) : '';
$carga = isset($_POST["carga_trem"]) ? trim($_POST["carga_trem"]) : '';
$capacidade  = isset($_POST["capacidade_trem"]) ? trim($_POST["capacidade_trem"]) : '';
$vagoes = isset($_POST["vagoes_trem"]) ? trim($_POST["vagoes_trem"]) : '';
$estado = isset($_POST["estado_trem"]) ? trim($_POST["estado_trem"]) : '';
$velocidade = isset($_POST["velocidade_trem"]) ? trim($_POST["velocidade_trem"]) : '';



// Validação de campos obrigatórios
if ($codigo === '' || $carga === '' || $capacidade === '' || $vagoes === '' || $estado === '' || $velocidade === '') {
    $error = "Preencha todos os campos obrigatórios.";
} else {
    if (!$conn) {
        die("Erro de conexão com o banco de dados.");
    }

    // Query correta com 4 parâmetros
    $stmt = $conn->prepare("
        INSERT INTO sensores 
        (carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem)
        VALUES (?, ?, ?, ?)
    ");

    if ($stmt) {
        $stmt->bind_param("ssss", $codigo, $carga, $capacidade, $vagoes, $estado, $velocidade);

        if ($stmt->execute()) {
            header("Location: ../public/gerenciamento_trens.php");
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
