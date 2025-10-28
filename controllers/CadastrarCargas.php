<?php
require_once __DIR__ . '/../db/conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

if (!isset($_SESSION['email_usuarios'])) {
    header('Location: ../public/login/cadastre-se-page.php');
    exit;
}

if (!isset($conn) || !$conn) {
    http_response_code(500);
    exit('Erro: conexão com o banco de dados.');
}

$email = $_SESSION['email_usuarios'];

$stmt_id = $conn->prepare("SELECT idusuarios FROM usuarios WHERE email_usuarios = ?");
if (!$stmt_id) {
    exit('Erro (prepare): ' . $conn->error);
}
$stmt_id->bind_param("s", $email);
if (!$stmt_id->execute()) {
    exit('Erro (execute): ' . $stmt_id->error);
}

$idusuario = null;
if (method_exists($stmt_id, 'get_result')) {
    $res = $stmt_id->get_result();
    $row = $res->fetch_assoc();
    $idusuario = $row['idusuarios'] ?? null;
    $res->free();
} else {
    $stmt_id->bind_result($id_tmp);
    if ($stmt_id->fetch()) $idusuario = $id_tmp;
}
$stmt_id->close();

if (!$idusuario) {
    exit('Erro: usuário não encontrado no banco.');
}

$tipocarga     = trim($_POST['tipocarga'] ?? '');
$tamanhocarga  = trim($_POST['tamanhocarga'] ?? '');
$pontopartida  = trim($_POST['pontopartida'] ?? '');
$pontodestino  = trim($_POST['pontodestino'] ?? '');
$envio_cargas  = trim($_POST['envio_cargas'] ?? '');
$chegada_cargas= trim($_POST['chegada_cargas'] ?? '');

if ($tipocarga === '' || $tamanhocarga === '' || $pontopartida === '' ||
    $pontodestino === '' || $envio_cargas === '' || $chegada_cargas === '') {
    exit('Preencha todos os campos obrigatórios.');
}

$stmt = $conn->prepare("
    INSERT INTO cargas 
    (tipo_carga, tamanho_carga, partida_carga, destino_carga, envio_cargas, chegada_cargas, idusuarios)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
if (!$stmt) {
    exit('Erro (prepare insert): ' . $conn->error);
}

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
    header('Location: ../public/relatorios_e_analises.php?status=success');
    exit;
} else {
    exit('Erro ao cadastrar carga: ' . $stmt->error);
}

$stmt->close();
$conn->close();
