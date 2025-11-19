<?php
require_once __DIR__ . '/../db/conn.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $tipo = trim($_POST['tipo_sensor'] ?? '');
    $localizacao = trim($_POST['localizacao_sensor'] ?? '');
    $data = trim($_POST['data_sensor'] ?? '');
    $observacao = trim($_POST['observacao_sensor'] ?? '');
    

    if ($id <= 0) {
        $msg = 'ID inválido para atualização.';
    } else {
        $stmt = $mysqli->prepare('UPDATE sensores SET tipo_sensor = ?, localizacao_sensor = ?, data_sensor = ?, observacao_sensor = ? WHERE idsensores = ?');
        if ($stmt) {
            $stmt->bind_param('ssssi', $tipo, $localizacao, $data, $observacao, $id);
            if ($stmt->execute()) {
                $msg = 'Sensor atualizada com sucesso.';
                $stmt->close();
                header('Location: remover_sensores.php');
                exit;
            } else {
                $msg = 'Erro ao atualizar sensor.';
            }
            $stmt->close();
        } else {
            $msg = 'Erro na preparação da query de atualização.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $mysqli->prepare('DELETE FROM cargas WHERE idsensores = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $msg = 'Sensor removida com sucesso.';
        } else {
            $msg = 'Erro ao remover sensor.';
        }
        $stmt->close();
    } else {
        $msg = 'Erro na preparação da query.';
    }
}

$editRow = null;
if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])) {
    $eid = intval($_GET['edit_id']);
    if ($eid > 0) {
        $stmt = $mysqli->prepare('SELECT idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor FROM sensores WHERE idsensores = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('i', $eid);
            $stmt->execute();
            $res = $stmt->get_result();
            $editRow = $res->fetch_assoc();
            $stmt->close();
        }
    }
}

$result = $mysqli->query('SELECT idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor FROM sensores ORDER BY idsensores DESC');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Excluir / Editar Sensor</title>
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 1100px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .msg { margin: 12px 0; color: green; }
        .error { color: red; }
        .edit-form { margin: 16px 0; padding: 12px; border: 1px solid #ccc; max-width: 800px; }
        .edit-form input, .edit-form textarea { width: 100%; padding: 6px; margin: 6px 0; box-sizing: border-box; }
        .actions { display:flex; gap:8px; }
    </style>
</head>
<body>
    <h1>Excluir / Editar Sensores</h1>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <p><a href="../public/adicionar_sensores.php">Voltar — Cadastro de Sensores</a></p>

    <?php if ($editRow): ?>
        <div class="edit-form">
            <h2>Editar Sensor #<?= (int)$editRow['idsensores'] ?></h2>
            <form method="post" action="remover_sensores.php">
                <input type="hidden" name="update_id" value="<?= (int)$editRow['idsensores'] ?>">
                <label>ID:</label>
                <input name="tipo_sensor" value="<?= htmlspecialchars($editRow['tipo_sensor']) ?>" required>
                <label>Tipo:</label>
                <input name="localizacao_sensor" value="<?= htmlspecialchars($editRow['localizacao_sensor']) ?>">
                <label>Localização:</label>
                <input name="data_sensor" value="<?= htmlspecialchars($editRow['data_sensor']) ?>">
                <label>Data:</label>
                <input name="observacao_sensor" value="<?= htmlspecialchars($editRow['observacao_sensor']) ?>">
                <label>Observação:</label>
                <div class="actions">
                    <button type="submit">Salvar</button>
                    <a href="remover_sensores.php">Cancelar</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Tamanho</th>
                    <th>Partida</th>
                    <th>Destino</th>
                    <th>Envio</th>
                    <th>Chegada</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$row['idcargas'] ?></td>
                        <td><?= htmlspecialchars($row['tipo_carga']) ?></td>
                        <td><?= htmlspecialchars($row['tamanho_carga']) ?></td>
                        <td><?= htmlspecialchars($row['partida_carga']) ?></td>
                        <td><?= htmlspecialchars($row['destino_carga']) ?></td>
                        <td><?= htmlspecialchars($row['envio_cargas']) ?></td>
                        <td><?= htmlspecialchars($row['chegada_cargas']) ?></td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <form method="post" onsubmit="return confirm('Deseja realmente excluir esta carga?');" style="display:inline">
                                    <input type="hidden" name="delete_id" value="<?= (int)$row['idcargas'] ?>">
                                    <button type="submit">Excluir</button>
                                </form>
                                <a href="excluir_cargas.php?edit_id=<?= (int)$row['idcargas'] ?>">Editar</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma carga encontrada.</p>
    <?php endif; ?>

</body>
</html>
<?php
$mysqli->close();
?>