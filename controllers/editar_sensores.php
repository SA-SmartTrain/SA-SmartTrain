<?php
<
require_once __DIR__ . '/../db/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "Não encontrado.";
        exit;
    }
    $id = (int)$_GET['id'];
    $stmt = $mysqli->prepare("SELECT idsensores, tipo_sensor, localizacao, data_sensor, observacoes FROM sensores WHERE idsensores = ?");
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
        <input name="localizacao" value="<?php echo htmlspecialchars($sensor['localizacao']); ?>">
        <label>Data:</label>
        <input name="data_sensor" value="<?php echo htmlspecialchars($sensor['data_sensor']); ?>">
        <label>Observação:</label>
        <textarea name="observacoes"><?php echo htmlspecialchars($sensor['observacoes']); ?></textarea>
        <button type="submit">Salvar</button>
    </form>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['idsensores'] ?? 0);
    $tipo = $_POST['tipo_sensor'] ?? '';
    $local = $_POST['localizacao'] ?? '';
    $data = $_POST['data_sensor'] ?? null;
    $obs = $_POST['observacoes'] ?? '';

    if ($id <= 0) {
        echo "ID inválido.";
        exit;
    }

    $stmt = $mysqli->prepare("UPDATE sensores SET tipo_sensor = ?, localizacao = ?, data_sensor = ?, observacoes = ? WHERE idsensores = ?");
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