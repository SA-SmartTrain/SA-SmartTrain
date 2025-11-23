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
                    <div class="seta">
                        <img src="../src/assets/images/seta.png" alt="Seta">
                    </div>
                    <a href="./pagina_inicial.php" style="text-decoration: none;">
                        <h1 id="title">Relatórios e Análises</h1>
                    </a>
                </div>

                <?php if ($success): ?>
                    <p style="color: green; margin: 10px 0;"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <p style="color: red; margin: 10px 0;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="flex-containers">
                        <div class="container_amarelo">Carga
                            <select name="tipocarga" required>
                                <option value="">Selecione a carga...</option>
                                <option value="Soja">Soja</option>
                                <option value="Milho">Milho</option>
                                <option value="Feijão">Feijão</option>
                                <option value="Ervilha">Ervilha</option>
                                <option value="Carvão">Carvão</option>
                                <option value="Açúcar">Açúcar</option>
                                <option value="Barras de Aço">Barras de Aço</option>
                                <option value="Minério">Minério</option>
                                <option value="Cereais">Cereais</option>
                                <option value="Petróleo">Petróleo</option>
                            </select>
                        </div>
                        <div class="container_amarelo">Data
                            <input type="date" name="data_relatorio" required>
                        </div>
                        <div class="container_amarelo">Quantidade
                            <select name="quantidade_relatorio" required>
                                <option value="">Selecione o tamanho...</option>
                                <option value="1-50 Toneladas">1-50 Toneladas</option>
                                <option value="50-100 Toneladas">50-100 Toneladas</option>
                                <option value="100-500 Toneladas">100-500 Toneladas</option>
                                <option value="500-1.000 Toneladas">500-1.000 Toneladas</option>
                                <option value="1.000-5.000 Toneladas">1.000-5.000 Toneladas</option>
                                <option value="5.000-10.000 Toneladas">5.000-10.000 Toneladas</option>
                                <option value="10.000-15.000 Toneladas">10.000-15.000 Toneladas</option>
                                <option value="Mais de 20 mil Toneladas">Mais de 20 mil Toneladas</option>
                                <option value="Mais de 50 mil Toneladas">Mais de 50 mil Toneladas</option>
                                <option value="Mais de 100 mil Toneladas">Mais de 100 mil Toneladas</option>
                                <option value="Mais de 500 mil Toneladas">Mais de 500 mil Toneladas</option>
                            </select>
                        </div>
                    </div>

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

        <div class="container-accessibility-buttons">
            <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
            <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
        </div>
    </main>
</body>
</html>