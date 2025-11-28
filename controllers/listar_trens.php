<?php
require_once __DIR__ . '/../db/conn.php';

if (!isset($mysqli) || !$mysqli) {
    echo '<p>Erro: conexão com o banco não disponível.</p>';
    exit;
}

$result = $mysqli->query("SELECT idtrens, carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem FROM trens ORDER BY idtrens DESC");
if (!$result) {
    echo '<p>Erro ao consultar trens: ' . htmlspecialchars($mysqli->error) . '</p>';
    exit;
}

$result->free();
?>

<?php
require_once __DIR__ . '/../db/conn.php';

if (!isset($mysqli) || !$mysqli) {
    echo '<p>Erro: conexão com o banco não disponível.</p>';
    exit;
}

$result = $mysqli->query("SELECT idtrens, carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem FROM trens ORDER BY idtrens DESC");
if (!$result) {
    echo '<p>Erro ao consultar sensores: ' . htmlspecialchars($mysqli->error) . '</p>';
    exit;
}

echo '<style>
    .tabela-sensores-container {
        background-color:rgb(242, 211, 124);
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
        color:rgb(242, 211, 124);
        padding: 12px;
        text-align: left;
        font-weight: bold;
        border-bottom: 2px solidrgb(242, 211, 124);
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
        color: rgb(242, 211, 124);
        text-decoration: none;
    }
    .tabela-sensores-container a:last-child {
        margin-right: 0;
    }
</style>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/pagina_inicial.css">
    <link rel="stylesheet" href="../style/global/container-size-mobile.css">
    <title>SmartTrain - Lista Trens</title>
</head>

<body>
    <div class="container">
        <div class="container-accessibility-buttons">
            <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
            <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
        </div>
        <a href="../../public/gerenciamento_geral_trens.php" style="text-decoration: none;">
            <h1 id="title">Listar Trens</h1>
        </a>
    </div>

    <?php
    echo '<div class="tabela-sensores-container">';
    echo '<table>';
    echo '<thead><tr>';
    echo '<th>ID</th><th>Carga</th><th>Capacidade</th><th>Vagões</th><th>Estado</th><th>Velocidade</th><th>Ações</th>';
    echo '</tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['idtrens']) . '</td>';
        echo '<td>' . htmlspecialchars($row['carga_trem']) . '</td>';
        echo '<td>' . htmlspecialchars($row['capacidade_trem']) . '</td>';
        echo '<td>' . htmlspecialchars($row['vagoes_trem']) . '</td>';
        echo '<td>' . htmlspecialchars($row['estado_trem']) . '</td>';
        echo '<td>' . htmlspecialchars($row['velocidade_trem']) . '</td>';
        echo '<td>';
        echo '<a href="../controllers/editar_trem.php?id=' . urlencode($row['idtrens']) . '">Editar</a> ';
        echo '<a href="../controllers/remover_trem.php?id=' . urlencode($row['idtrens']) . '">Excluir</a>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    echo '</div>';

    $result->free();
    $mysqli->close();
    ?>

    <div class="container-menu-bar" style="position: relative; bottom: -540px;">
        <div class="sections-menu-bar" id="press-effect">
            <img src="../src/assets/images/inicio-bar.png" alt="">
            <div id="incio">
                <a href="../public/pagina_inicial.php"><span>Início</span></a>
            </div>
        </div>
        <div class="sections-menu-bar" id="press-effect">
            <img src="../src/assets/images/menu-bar.png" alt="">
            <a href="../public/documentacoes.html"><span>Menu</span></a>
        </div>
        <div class="sections-menu-bar" id="press-effect">
            <img src="../src/assets/images/estoque-bar.png" alt="">
            <a href="../public/relatorios_e_analises.php"><span>Estoque</span></a>
        </div>
        <div class="sections-menu-bar" id="press-effect">
            <div id="funcionarios"><img src="../src/assets/images/funcionarios-bar.png" alt=""></div>
            <a href="../public/funcionarios.php"><span>Funcionários</span></a>
        </div>
    </div>
</body>

</html>