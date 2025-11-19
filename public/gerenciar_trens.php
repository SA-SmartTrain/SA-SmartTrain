<?php

require_once('../db/conn.php');

$carga_trem = $_POST['carga_trem']?? '';

$resultado = $conn->query("SELECT idcargas FROM cargas WHERE tipo_carga = '".$carga_trem."';");

if ($resultado->num_rows >= 1) {

    $row = $resultado->fetch_assoc();
    $id_carga = $row["idcargas"];
    // Coleta dados do POST
    $carga = $_POST['carga_trem'] ?? 'NULL';
    $capacidade = $_POST['capacidade_trem'] ?? '';
    $vagoes = $_POST['vagoes_trem'] ?? '';
    $estado = $_POST['estado_trem'] ?? '';
    $velocidade = $_POST['velocidade_trem'] ?? '';

    if (!empty($carga_trem)) {

        // $stmt = $conn->prepare("INSERT INTO trens (carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem) VALUES (?, ?, ?, ?, ?)");
        $stmt = $conn->prepare("INSERT INTO trens (carga_trem,capacidade_trem, vagoes_trem, estado_trem, velocidade_trem) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssss",
            $carga,
            $capacidade,
            $vagoes,
            $estado,
            $velocidade
        );

        if ($stmt->execute()) {
            header("Location: ./gerenciamento_trens.php");
            echo ("Carga Cadastrada.");
            exit;
        } else {
            echo "Erro ao cadastrar carga: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
