<?php
require_once __DIR__ . '/../db/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "Não encontrado.";
        exit;
    }
    $id = (int)$_GET['id'];
    $stmt = $mysqli->prepare("SELECT idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor FROM sensores WHERE idsensores = ?");
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
    <html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Sensor</title>
        <link rel="stylesheet" href="../src/assets/css/bootstrap.min.css">
        <style>
            body { padding: 20px; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
            button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background-color: #0056b3; }
            .btn-secondary { background-color: #6c757d; }
            .btn-secondary:hover { background-color: #545b62; }
        </style>
    </head>
    <body>
        <div class="container" style="max-width: 500px;">
            <h2>Editar Sensor #<?php echo htmlspecialchars($sensor['idsensores']); ?></h2>
            <form method="post" action="../controllers/editar_sensores.php">
                <input type="hidden" name="idsensores" value="<?php echo htmlspecialchars($sensor['idsensores']); ?>">
                
                <div class="form-group">
                    <label>Tipo de Sensor:</label>
                    <select name="tipo_sensor" required>
                        <option value="<?php echo htmlspecialchars($sensor['tipo_sensor']); ?>" selected><?php echo htmlspecialchars($sensor['tipo_sensor']); ?></option>
                        <option value="Ultrassonico">Ultrassonico</option>
                        <option value="LDR (luminosidade)">LDR (luminosidade)</option>
                        <option value="Sensor DHT11">Sensor DHT11</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Localização:</label>
                    <select name="localizacao_sensor" required>
                        <option value="<?php echo htmlspecialchars($sensor['localizacao_sensor']); ?>" selected><?php echo htmlspecialchars($sensor['localizacao_sensor']); ?></option>
                        <option value="Trilho 1-Sul">Trilho 1-Sul</option>
                        <option value="Trilho 1-Norte">Trilho 1-Norte</option>
                        <option value="Trilho 2-Sul">Trilho 2-Sul</option>
                        <option value="Trilho 2-Norte">Trilho 2-Norte</option>
                        <option value="Trilho 3-Sul">Trilho 3-Sul</option>
                        <option value="Trilho 3-Norte">Trilho 3-Norte</option>
                        <option value="Trilho 4-Sul">Trilho 4-Sul</option>
                        <option value="Trilho 4-Norte">Trilho 4-Norte</option>
                        <option value="Trilho 5-Sul">Trilho 5-Sul</option>
                        <option value="Trilho 5-Norte">Trilho 5-Norte</option>
                        <option value="Trilho 6-Sul">Trilho 6-Sul</option>
                        <option value="Trilho 6-Norte">Trilho 6-Norte</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Data:</label>
                    <input type="date" name="data_sensor" value="<?php echo htmlspecialchars($sensor['data_sensor']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Observação:</label>
                    <textarea name="observacao_sensor" rows="4"><?php echo htmlspecialchars($sensor['observacao_sensor']); ?></textarea>
                </div>

                <button type="submit">Salvar</button>
                <a href="../public/listar_sensores.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['idsensores'] ?? 0);
    $tipo = $_POST['tipo_sensor'] ?? '';
    $local = $_POST['localizacao_sensor'] ?? '';
    $data = $_POST['data_sensor'] ?? null;
    $obs = $_POST['observacao_sensor'] ?? '';

    if ($id <= 0) {
        echo "ID inválido.";
        exit;
    }

    $stmt = $mysqli->prepare("UPDATE sensores SET tipo_sensor = ?, localizacao_sensor = ?, data_sensor = ?, observacao_sensor = ? WHERE idsensores = ?");
    $stmt->bind_param('ssssi', $tipo, $local, $data, $obs, $id);
    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ../public/listar_sensores.php'); 
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
    $stmt->close();
}
?>