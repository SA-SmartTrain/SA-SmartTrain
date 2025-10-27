<?php

require_once('../db/conn.php');

$carga_trem = $_POST['carga_trem']?? '';

$resultado = $conn->query("SELECT idcargas FROM cargas WHERE tipo_carga = '".$carga_trem."';");

if ($resultado->num_rows >= 1) {

    $row = $resultado->fetch_assoc();
    $id_carga = $row["idcargas"];
    // Coleta dados do POST
    $identificador = $_POST['identificador_trem'] ?? 'NULL';
    $capacidade_trem = $_POST['capacidade_trem'] ?? '';
    $vagoes_trem = $_POST['vagoes_trem'] ?? '';
    $estado_trem = $_POST['estado_trem'] ?? '';
    $velocidade_trem = $_POST['velocidade_trem'] ?? '';

    if (!empty($carga_trem)) {

        // $stmt = $conn->prepare("INSERT INTO trens (carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem) VALUES (?, ?, ?, ?, ?)");
        $stmt = $conn->prepare("INSERT INTO trens (identificador_trem,capacidade_maxima, quantidade_vagoes, velocidade_maxima, estado_atual, tipo_carga, fk_carga) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssssssi",
            $identificador,
            $capacidade_trem,
            $vagoes_trem,
            $velocidade_trem,
            $estado_trem,
            $carga_trem,
            $id_carga
        );

        if ($stmt->execute()) {
            header("Location: ./pagina_inicial.php?msg=Carga cadastrada com sucesso");
            exit;
        } else {
            echo "Erro ao cadastrar carga: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
