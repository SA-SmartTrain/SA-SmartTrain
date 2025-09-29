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

    $foto_nome = null;
    if (isset($_FILES['foto_usuarios']) && $_FILES['foto_usuarios']['error'] === UPLOAD_ERR_OK) {
        $pasta_destino = __DIR__ . '/uploads/'; // Crie esta pasta se não existir
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }

        $extensao = pathinfo($_FILES['foto_usuarios']['name'], PATHINFO_EXTENSION);
        $foto_nome = uniqid('perfil_', true) . '.' . $extensao;
        $caminho_completo = $pasta_destino . $foto_nome;

        if (!move_uploaded_file($_FILES['foto_usuarios']['tmp_name'], $caminho_completo)) {
            die("Erro ao fazer upload da imagem.");
        }
    }

    // Atualiza os dados no banco
    if ($foto_nome) {
        $stmt = $conn->prepare("UPDATE usuarios 
                                SET nome_usuarios = ?, email_usuarios = ?, telefone_usuario = ?, endereco_usuario = ?, foto_usuarios = ? 
                                WHERE email_usuarios = ?");
        $stmt->bind_param("ssssss", $novo_nome, $novo_email, $novo_telefone, $novo_endereco, $foto_nome, $email);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios 
                                SET nome_usuarios = ?, email_usuarios = ?, telefone_usuario = ?, endereco_usuario = ? 
                                WHERE email_usuarios = ?");
        $stmt->bind_param("sssss", $novo_nome, $novo_email, $novo_telefone, $novo_endereco, $email);
    }

    if (!$stmt) {
        die("Erro na preparação da consulta de atualização: " . $conn->error);
    }

    if ($stmt->execute()) {
        $_SESSION["email_usuarios"] = $novo_email;
        header('Location: meu_perfil_beta.php');
        exit;
    } else {
        echo "Erro ao atualizar os dados: " . $stmt->error;
    }
}

$conn->close();
?>
