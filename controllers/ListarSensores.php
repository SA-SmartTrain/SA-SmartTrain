<?php
require_once __DIR__ . '/../db/conn.php';

if (!isset($mysqli) || !$mysqli) {
    echo '<p>Erro: conexão com o banco não disponível.</p>';
    exit;
}

$result = $mysqli->query("SELECT idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor FROM sensores ORDER BY idsensores ASC");
if (!$result) {
    echo '<p>Erro ao consultar sensores: ' . htmlspecialchars($mysqli->error) . '</p>';
    exit;
}

echo '<table class="table" style="width:100%; border-collapse:collapse;">';
echo '<thead><tr>';
echo '<th>ID</th><th>Tipo</th><th>Localização</th><th>Data</th><th>Observação</th><th>Ações</th>';
echo '</tr></thead>';
echo '<tbody>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['idsensores']) . '</td>';
    echo '<td>' . htmlspecialchars($row['tipo_sensor']) . '</td>';
    echo '<td>' . htmlspecialchars($row['localizacao_sensor']) . '</td>';
    echo '<td>' . htmlspecialchars($row['data_sensor']) . '</td>';
    echo '<td>' . htmlspecialchars($row['observacao_sensor']) . '</td>';
    echo '<td>';
    echo '<a href="../controllers/editar_sensores.php?id=' . urlencode($row['idsensores']) . '">Editar</a> ';
    echo '<a href="../controllers/remover_sensores.php?id=' . urlencode($row['idsensores']) . '">Excluir</a>';
    echo '</td>';
    echo '</tr>';
}
echo '</tbody></table>';

$result->free();
$mysqli->close();
?>
