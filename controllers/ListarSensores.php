<?php
require_once __DIR__ . '/../db/conn.php';

// Consulta todos os sensores
$stmt = $conn->prepare("SELECT idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor FROM sensores ORDER BY idsensores ASC");
$stmt->execute();
$resultado = $stmt->get_result();

while ($row = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['idsensores']) . "</td>";
    echo "<td>" . htmlspecialchars($row['tipo_sensor']) . "</td>";
    echo "<td>" . htmlspecialchars($row['localizacao_sensor']) . "</td>";
    echo "<td>" . htmlspecialchars($row['data_sensor']) . "</td>";
    echo "<td>" . htmlspecialchars($row['observacao_sensor']) . "</td>";
    echo "<td>
            <a href='remover_sensores.php?id=" . htmlspecialchars($row['idsensores']) . "' class='btn btn-danger btn-sm'>Excluir</a>
          </td>";
    echo "</tr>";
}

$stmt->close();
?>
