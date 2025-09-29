<?php
require_once(__DIR__ . '/../db/conn.php');

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../login/cadastro-se-dados.php');
    exit;
}

// Pega o email da sessão
$email = $_SESSION["email_usuarios"];

// Deleta o usuário do banco
$stmt = $conn->prepare("DELETE FROM usuarios WHERE email_usuarios = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    // Se deletado com sucesso, encerra a sessão
    session_unset();
    session_destroy();

    // Redireciona para a página de cadastro/login
    header('Location: ../login/cadastro-se-dados.php?mensagem=conta_excluida');
    exit;
} else {
    echo "Erro ao excluir conta: " . $stmt->error;
}

$stmt->close();
$conn->close();
