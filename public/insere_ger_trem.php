<?php

require_once('../db/conn.php');

$stmt = $conn->prepare("SELECT * FROM trens WHERE identificador_trem = ?");
$stmt->bind_param('i', $_POST['codigo_trem']);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows >= 1) {

    // Coleta dados do POST
    $codigo = $_POST['codigo_trem'];
    $destino = $_POST['destino'] ?? '';
    $causa = $_POST['causa'] ?? '';
    $fk_trem = $_POST['fk_trem'] ?? 1;

    $stmt = $conn->prepare("INSERT INTO gerenciamento_trens (codigo, destino, causa, fk_trem) VALUES (?, ?, ?, ?)");

    $stmt->bind_param(
        "issi",
        $codigo,
        $destino,
        $causa,
        $fk_trem,
    );

    if ($stmt->execute()) {
        echo "Carga cadastrada com sucesso!";

        header("Location: ./pagina_inicial.php");
    } else {
        echo "Erro ao cadastrar carga: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
