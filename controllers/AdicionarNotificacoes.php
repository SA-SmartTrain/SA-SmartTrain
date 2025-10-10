<?php
require_once __DIR__ . '/../db/conn.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../public/login/cadastre-se-page.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $texto = trim($_POST["notificacao"] ?? "");

    // Se o campo estiver vazio, redireciona com erro
    if (empty($texto)) {
        header("Location: ../public/alertas_e_notificacoes.php?erro=1");
        exit;
    }

    // Inserção segura com prepared statement
    $stmt = $conn->prepare("INSERT INTO notificacoes (observacao_notificacoes) VALUES (?)");
    $stmt->bind_param("s", $texto);

    if ($stmt->execute()) {
        header("Location: ../public/alertas_e_notificacoes.php?sucesso=1");
        exit;
    } else {
        header("Location: ../public/alertas_e_notificacoes.php?erro_db=" . urlencode($stmt->error));
        exit;
    }
}
