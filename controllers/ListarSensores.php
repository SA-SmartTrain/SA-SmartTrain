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

echo '<style>
    .tabela-sensores-container {
        background-color: #FFC107;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
    }
    .tabela-sensores-container table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        font-family: Arial, sans-serif;
    }
    .tabela-sensores-container th {
        background-color: #2C2C2C;
        color: #FFC107;
        padding: 12px;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solid #FFC107;
    }
    .tabela-sensores-container td {
        padding: 10px 12px;
        border-bottom: 1px solid #ddd;
    }
    .tabela-sensores-container tr:hover {
        background-color: #f9f9f9;
    }
    .tabela-sensores-container a {
        color: #2C2C2C;
        text-decoration: none;
        margin-right: 15px;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    .tabela-sensores-container a:hover {
        background-color: #2C2C2C;
        color: #FFC107;
        text-decoration: none;
    }
    .tabela-sensores-container a:last-child {
        margin-right: 0;
    }
</style>';

echo '<div class="tabela-sensores-container">';
echo '<table>';
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
    echo '<a href="../controllers/editar_sensores.php?id=' . urlencode($row['idsensores']) . '">Editar</a>';
    echo '<a href="../controllers/remover_sensores.php?id=' . urlencode($row['idsensores']) . '">Excluir</a>';
    echo '</td>';
    echo '</tr>';
}
echo '</tbody></table>';
echo '</div>';

$result->free();
$mysqli->close();
?>


