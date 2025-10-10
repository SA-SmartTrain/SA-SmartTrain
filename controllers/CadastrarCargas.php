<?php
require_once __DIR__ . '/../db/conn.php';
session_start();

// Verifica se usuário está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../public/login/cadastre-se-page.php');
    exit;
}

// Pega o email da sessão
$email = $_SESSION["email_usuarios"];

// Busca o idusuario correspondente
$stmt_id = $conn->prepare("SELECT idusuarios FROM usuarios WHERE email_usuarios = ?");
$stmt_id->bind_param("s", $email);
$stmt_id->execute();
$result_id = $stmt_id->get_result();
$row = $result_id->fetch_assoc();
$idusuario = $row['idusuarios'] ?? null;

if (!$idusuario) {
    die("Erro: usuário não encontrado no banco.");
}

// Coleta dados do POST
$tipocarga = $_POST['tipocarga'] ?? '';
$tamanhocarga = $_POST['tamanhocarga'] ?? '';
$pontopartida = $_POST['pontopartida'] ?? '';
$pontodestino = $_POST['pontodestino'] ?? '';
$envio_cargas = $_POST['envio_cargas'] ?? '';
$chegada_cargas = $_POST['chegada_cargas'] ?? '';

// Validação
if (!$tipocarga || !$tamanhocarga || !$pontopartida || !$pontodestino || !$envio_cargas || !$chegada_cargas) {
    die("Preencha todos os campos obrigatórios.");
}

// Inserção no banco
$stmt = $conn->prepare("
    INSERT INTO cargas 
    (tipo_carga, tamanho_carga, partida_carga, destino_carga, envio_cargas, chegada_cargas, idusuarios)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssi",
    $tipocarga,
    $tamanhocarga,
    $pontopartida,
    $pontodestino,
    $envio_cargas,
    $chegada_cargas,
    $idusuario
);

if ($stmt->execute()) {
    echo "Carga cadastrada com sucesso!";
} else {
    echo "Erro ao cadastrar carga: " . $stmt->error;
}

$stmt->close();
$conn->close();
