<?php
require_once(__DIR__ . '/../db/conn.php');

session_start();

// Verifica se o usuário já está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../login/cadastro-se-dados.php');
    exit;
}

// Pega o email da sessão (email antigo, usado no WHERE)
$email = $_SESSION["email_usuarios"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome     = trim($_POST["nome_usuarios"] ?? "");
    $novo_email    = trim($_POST["email_usuarios"] ?? "");
    $novo_telefone = trim($_POST["telefone_usuario"] ?? "");
    $novo_endereco = trim($_POST["endereco_usuario"] ?? "");

    // Atualiza os dados no banco
    $stmt = $conn->prepare("UPDATE usuarios 
                            SET nome_usuarios = ?, email_usuarios = ?, telefone_usuario = ?, endereco_usuario = ? 
                            WHERE email_usuarios = ?");
    if (!$stmt) {
        die("Erro na preparação da consulta de atualização: " . $conn->error);
    }

    $stmt->bind_param("sssss", $novo_nome, $novo_email, $novo_telefone, $novo_endereco, $email);

    if ($stmt->execute()) {
        // Atualiza o email na sessão se mudou
        $_SESSION["email_usuarios"] = $novo_email;
        header('Location: meu_perfil_beta.php');
        exit;
    } else {
        echo "Erro ao atualizar os dados: " . $stmt->error;
    }
}

$conn->close();
?>