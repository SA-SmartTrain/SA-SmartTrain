<?php
require_once __DIR__ . '/../db/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "Não encontrado.";
        exit;
    }
    $id = (int) $_GET['id'];

    $stmt = $mysqli->prepare("SELECT idsensores, tipo_sensor, localizacao_sensor FROM sensores WHERE idsensores = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $sensor = $res->fetch_assoc();
    $stmt->close();

    if (!$sensor) {
        echo "Sensor não encontrado.";
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Confirmar exclusão</title>
        <link rel="stylesheet" href="../src/assets/css/bootstrap.min.css"> 
    </head>
    <body class="p-4">
        <div class="container">
            <h4>Confirmar exclusão</h4>
            <p>Deseja realmente excluir o sensor #<?php echo htmlspecialchars($sensor['idsensores']); ?> —
               <?php echo htmlspecialchars($sensor['tipo_sensor']); ?> (<?php echo htmlspecialchars($sensor['localizacao_sensor']); ?>)?</p>

            <form method="post" action="" class="d-inline">
                <input type="hidden" name="idsensores" value="<?php echo htmlspecialchars($sensor['idsensores']); ?>">
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
            <a href="../controllers/ListarSensores.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idsensores'] ?? null;
    if (!$id || !is_numeric($id)) {
        echo "ID inválido.";
        exit;
    }
    $id = (int) $id;

    $stmt = $mysqli->prepare("DELETE FROM sensores WHERE idsensores = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ');
        exit;
    } else {
        echo "Erro ao excluir o sensor: " . $stmt->error;
    }

    $stmt->close();
}
?>