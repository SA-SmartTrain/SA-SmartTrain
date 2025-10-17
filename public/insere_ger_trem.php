<?php

require_once('../db/conn.php');

$stmt = $conn->prepare("SELECT * FROM trens WHERE identificador_trem = ?");
$stmt->bind_param('s', $_POST['codigo_trem']);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows >= 1) {
    

    header("Location: ./pagina_inicial.php");
} else {
    echo 'NÃO EXISTE.';
    return false;
}




?>