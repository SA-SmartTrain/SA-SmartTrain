<?php
require_once __DIR__ . '/../db/conn.php';

$success = '';
$error = '';

if (!isset($mysqli) || !$mysqli) {
    $error = 'Conexão com o banco não encontrada. Verifique db/conn.php';
} else {
    $table = 'relatorios';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids'])) {
        $sql = "UPDATE {$table} SET carga_relatorio = ?, data_relatorio = ?, quantidade_relatorio = ? WHERE idrelatorios = ?";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            $error = 'Erro ao preparar statement: ' . $mysqli->error;
        } else {
            foreach ($_POST['ids'] as $id) {
                $id = (int)$id;
                $carga = isset($_POST['carga'][$id]) ? trim($_POST['carga'][$id]) : '';
                $data = isset($_POST['data'][$id]) ? trim($_POST['data'][$id]) : '';
                $quantidade = isset($_POST['quantidade'][$id]) ? trim($_POST['quantidade'][$id]) : '';

                $stmt->bind_param('sssi', $carga, $data, $quantidade, $id);
                if (!$stmt->execute()) {
                    $error = 'Erro ao atualizar ID ' . $id . ': ' . $stmt->error;
                    break;
                }
            }
            if ($error === '') $success = 'Alterações salvas com sucesso.';
            $stmt->close();
        }
    }

    $result = $mysqli->query("SELECT idrelatorios, carga_relatorio, data_relatorio, quantidade_relatorio FROM relatorios ORDER BY idrelatorios ASC");
    $rows = [];
    if ($result) {
        while ($r = $result->fetch_assoc()) $rows[] = $r;
        $result->free();
    } else {
        if ($error === '') $error = 'Erro ao carregar registros: ' . $mysqli->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/relatorios_e_analises.css">
    <title>Relatórios e Análises</title>
</head>
<body>
    <main>
        <section>
            <div class="container">
                <div id="topo" class="flex">
                         <div class="container-accessibility-buttons">
            <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
            <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
        </div>
                    </div>
                        <h1 id="title">Relatórios e Análises</h1>
                    </a>
                </div>

                <?php if ($success): ?>
                    <p style="color: green; margin: 10px 0;"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <p style="color: red; margin: 10px 0;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                

                    <h2 style="margin-top: 30px;">Registros</h2>
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                        <thead>
                            <tr style="background-color: #f4f4f4;">
                                <th style="border: 1px solid #ddd; padding: 8px;">ID</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Carga</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Data</th>
                                <th style="border: 1px solid #ddd; padding: 8px;">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td style="border: 1px solid #ddd; padding: 8px;">
                                            <input type="hidden" name="ids[]" value="<?php echo htmlspecialchars($row['idrelatorios']); ?>">
                                            <?php echo htmlspecialchars($row['idrelatorios']); ?>
                                        </td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">
                                            <input type="text" name="carga[<?php echo $row['idrelatorios']; ?>]" value="<?php echo htmlspecialchars($row['carga_relatorio']); ?>" style="width: 100%; padding: 4px;" />
                                        </td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">
                                            <input type="date" name="data[<?php echo $row['idrelatorios']; ?>]" value="<?php echo htmlspecialchars($row['data_relatorio']); ?>" style="width: 100%; padding: 4px;" />
                                        </td>
                                        <td style="border: 1px solid #ddd; padding: 8px;">
                                            <input type="text" name="quantidade[<?php echo $row['idrelatorios']; ?>]" value="<?php echo htmlspecialchars($row['quantidade_relatorio']); ?>" style="width: 100%; padding: 4px;" />
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align: center;">Nenhum registro encontrado</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <button type="submit" style="padding: 10px 20px; background-color: #FFC107; color: black; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Salvar Alterações</button>
                </form>
            </div>
        </section>

        <div class="container-menu-bar">
            <div class="sections-menu-bar" id="press-effect">
                <img src="../src/assets/images/inicio-bar.png" alt="">
                <a href="../public/pagina_inicial.php"><span>Início</span></a>
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
                <img src="../src/assets/images/funcionarios-bar.png" alt="">
                <a href="../public/funcionarios.php"><span>Funcionários</span></a>
            </div>
        </div>
    </main>
</body>
</html>