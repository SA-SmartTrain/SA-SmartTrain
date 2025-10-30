<?php
require_once __DIR__ . '/../db/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        echo "Não encontrado.";
        exit;
    }
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor FROM sensores WHERE idsensores = ?");
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
    <form method="post" action="editar_sensores.php">
        <input type="hidden" name="idsensores" value="<?php echo htmlspecialchars($sensor['idsensores']); ?>">
        <label>Tipo:</label>
        <input name="tipo_sensor" value="<?php echo htmlspecialchars($sensor['tipo_sensor']); ?>">
        <label>Localização:</label>
        <input name="localizacao_sensor" value="<?php echo htmlspecialchars($sensor['localizacao_sensor']); ?>">
        <label>Data:</label>
        <input name="data_sensor" value="<?php echo htmlspecialchars($sensor['data_sensor']); ?>">
        <label>Observação:</label>
        <textarea name="observacao_sensor"><?php echo htmlspecialchars($sensor['observacao_sensor']); ?></textarea>
        <button type="submit">Salvar</button>
    </form>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idsensores'] ?? null;
    $tipo = $_POST['tipo_sensor'] ?? '';
    $local = $_POST['localizacao_sensor'] ?? '';
    $data = $_POST['data_sensor'] ?? null;
    $obs = $_POST['observacao_sensor'] ?? '';

    $stmt = $conn->prepare("UPDATE sensores SET tipo_sensor = ?, localizacao_sensor = ?, data_sensor = ?, observacao_sensor = ? WHERE idsensores = ?");
    $stmt->bind_param('ssssi', $tipo, $local, $data, $obs, $id);
    if ($stmt->execute()) {
        header('Location: listar_sensores.php'); 
        exit;
    } else {
        echo "Erro ao atualizar.";
    }
    $stmt->close();
}
?>