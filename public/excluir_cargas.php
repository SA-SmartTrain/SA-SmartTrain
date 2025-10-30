<?php
require_once __DIR__ . '/../db/conn.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $tipo = trim($_POST['tipo_carga'] ?? '');
    $tamanho = trim($_POST['tamanho_carga'] ?? '');
    $partida = trim($_POST['partida_carga'] ?? '');
    $destino = trim($_POST['destino_carga'] ?? '');
    $envio = trim($_POST['envio_cargas'] ?? '');
    $chegada = trim($_POST['chegada_cargas'] ?? '');

    if ($id <= 0) {
        $msg = 'ID inválido para atualização.';
    } else {
        $stmt = $mysqli->prepare('UPDATE cargas SET tipo_carga = ?, tamanho_carga = ?, partida_carga = ?, destino_carga = ?, envio_cargas = ?, chegada_cargas = ? WHERE idcargas = ?');
        if ($stmt) {
            $stmt->bind_param('ssssssi', $tipo, $tamanho, $partida, $destino, $envio, $chegada, $id);
            if ($stmt->execute()) {
                $msg = 'Carga atualizada com sucesso.';
                $stmt->close();
                header('Location: excluir_cargas.php');
                exit;
            } else {
                $msg = 'Erro ao atualizar carga.';
            }
            $stmt->close();
        } else {
            $msg = 'Erro na preparação da query de atualização.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $mysqli->prepare('DELETE FROM cargas WHERE idcargas = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $msg = 'Carga removida com sucesso.';
        } else {
            $msg = 'Erro ao remover carga.';
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
        $stmt = $mysqli->prepare('SELECT idcargas, tipo_carga, tamanho_carga, partida_carga, destino_carga, envio_cargas, chegada_cargas FROM cargas WHERE idcargas = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('i', $eid);
            $stmt->execute();
            $res = $stmt->get_result();
            $editRow = $res->fetch_assoc();
            $stmt->close();
        }
    }
}

$result = $mysqli->query('SELECT idcargas, tipo_carga, tamanho_carga, partida_carga, destino_carga, envio_cargas, chegada_cargas FROM cargas ORDER BY idcargas DESC');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Excluir / Editar Cargas</title>
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
    <h1>Excluir / Editar Cargas</h1>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <p><a href="../public/cadastro_de_cargas.php">Voltar — Cadastro de Cargas</a></p>

    <?php if ($editRow): ?>
        <div class="edit-form">
            <h2>Editar Carga #<?= (int)$editRow['idcargas'] ?></h2>
            <form method="post" action="excluir_cargas.php">
                <input type="hidden" name="update_id" value="<?= (int)$editRow['idcargas'] ?>">
                <label>Tipo:</label>
                <input name="tipo_carga" value="<?= htmlspecialchars($editRow['tipo_carga']) ?>" required>
                <label>Tamanho:</label>
                <input name="tamanho_carga" value="<?= htmlspecialchars($editRow['tamanho_carga']) ?>">
                <label>Partida:</label>
                <input name="partida_carga" value="<?= htmlspecialchars($editRow['partida_carga']) ?>">
                <label>Destino:</label>
                <input name="destino_carga" value="<?= htmlspecialchars($editRow['destino_carga']) ?>">
                <label>Envio:</label>
                <input name="envio_cargas" value="<?= htmlspecialchars($editRow['envio_cargas']) ?>">
                <label>Chegada:</label>
                <input name="chegada_cargas" value="<?= htmlspecialchars($editRow['chegada_cargas']) ?>">
                <div class="actions">
                    <button type="submit">Salvar</button>
                    <a href="excluir_cargas.php">Cancelar</a>
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