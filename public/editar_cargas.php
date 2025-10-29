<?php
require_once __DIR__ . '/../db/conn.php';

$msg = '';
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

$result = $mysqli->query('SELECT idcargas, tipo_carga, tamanho_carga, partida_carga, destino_carga, envio_cargas, chegada_cargas FROM cargas ORDER BY idcargas DESC');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar Cargas</title>
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 1100px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .msg { margin: 12px 0; color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Editar Cargas</h1>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <p><a href="../public/cadastro_de_cargas.php">Voltar — Cadastro de Cargas</a></p>

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
                            <form method="post" onsubmit="return confirm('Deseja realmente editar esta carga?');" style="display:inline">
                                <input type="hidden" name="edit_id" value="<?= (int)$row['idcargas'] ?>">
                                <button type="submit">Editar</button>
                            </form>
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
