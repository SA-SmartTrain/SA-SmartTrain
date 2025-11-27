<?php
require_once __DIR__ . '/../db/conn.php';

if (!isset($mysqli) || !$mysqli) {
    echo '<p>Erro: conexão com o banco não disponível.</p>';
    exit;
}

$result = $mysqli->query("SELECT idtrens, identificador_trem, carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem FROM trens ORDER BY idtrens DESC");
if (!$result) {
    echo '<p>Erro ao consultar trens: ' . htmlspecialchars($mysqli->error) . '</p>';
    exit;
}

echo '<table class="table" style="width:100%; border-collapse:collapse; font-family: Arial">';
echo '<thead><tr>';
echo '<th>ID</th><th>Identificador</th><th>Carga</th><th>Capacidade</th><th>Vagões</th><th>Estado</th><th>Velocidade</th><th>Ações</th>';
echo '</tr></thead>';
echo '<tbody>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['idtrens']) . '</td>';
    echo '<td>' . htmlspecialchars($row['identificador_trem'] ?? 'N/A') . '</td>';
    echo '<td>' . htmlspecialchars($row['carga_trem']) . '</td>';
    echo '<td>' . htmlspecialchars($row['capacidade_trem']) . '</td>';
    echo '<td>' . htmlspecialchars($row['vagoes_trem']) . '</td>';
    echo '<td>' . htmlspecialchars($row['estado_trem']) . '</td>';
    echo '<td>' . htmlspecialchars($row['velocidade_trem']) . '</td>';
    echo '<td>';
    echo '<a href="../controllers/editar_trem.php?id=' . urlencode($row['idtrens']) . '">Editar</a> ';
    echo '<a href="../controllers/remover_trem.php?id=' . urlencode($row['idtrens']) . '">Excluir</a>';
    echo '</td>';
    echo '</tr>';
}
echo '</tbody></table>';

$result->free();
$mysqli->close();
?>