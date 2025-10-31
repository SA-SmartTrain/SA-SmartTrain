<?php
// ...existing code...
require_once __DIR__ . '/../db/conn.php';

$success = '';
$error = '';

if (!isset($mysqli) || !$mysqli) {
    $error = 'Conexão com o banco não encontrada. Verifique db/conn.php';
} else {
    // tabela (troque se seu BD usar outro nome)
    $table = 'relatorios';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids'])) {
        $sql = "UPDATE {$table} SET carga = ?, data = NULLIF(?,''), quantidade = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            $error = 'Erro ao preparar statement: ' . $mysqli->error;
        } else {
            foreach ($_POST['ids'] as $id) {
                $id = (int)$id;
                $carga = isset($_POST['carga'][$id]) ? trim($_POST['carga'][$id]) : '';
                $data = isset($_POST['data'][$id]) && $_POST['data'][$id] !== '' ? $_POST['data'][$id] : '';
                $quantidade = isset($_POST['quantidade'][$id]) ? (int)$_POST['quantidade'][$id] : 0;

                $stmt->bind_param('ssii', $carga, $data, $quantidade, $id);
                if (!$stmt->execute()) {
                    $error = 'Erro ao atualizar ID ' . $id . ': ' . $stmt->error;
                    break;
                }
            }
            if ($error === '') $success = 'Alterações salvas com sucesso.';
            $stmt->close();
        }
    }

    $result = $mysqli->query("SELECT id, carga, data, quantidade FROM {$table} ORDER BY id ASC");
    $rows = [];
    if ($result) {
        while ($r = $result->fetch_assoc()) $rows[] = $r;
        $result->free();
    } else {
        // se tabela não existir ou erro, mostra mensagem breve
        if ($error === '') $error = 'Erro ao carregar registros: ' . $mysqli->error;
    }
}
// ...existing code...
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/relatorios_e_analises.css">
    <title>SmartTrain - Relatórios e Análises</title>
</head>

<body>
    <main>
        <section>
            <div class="container">
                <div class="container-accessibility-buttons">
                    <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                    <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
                </div>
                <div id="topo" class="flex">
                    <a href="./pagina_inicial.php" style="text-decoration: none; color: #2C2C2C;">
                        <h1 id="title">Relatórios e Análises</h1>
                    </a>
                </div>

                <?php if ($success): ?><div class="notice success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
                <?php if ($error): ?><div class="notice error"><?= htmlspecialchars($error) ?></div><?php endif; ?>

                <form method="post" action="">
                    <div class="flex header">
                        <div class="container_amarelo">Carga
                             <form action="../controllers/CadastrarCargas.php" method="POST">
            <select name="tipocarga" required>
                <option value="Soja">Soja</option>
                <option value="Milho">Milho</option>
                <option value="Feijão">Feijão</option>
                <option value="Ervilha">Ervilha</option>
                <option value="Carvão">Carvão</option>
                <option value="Açucar">Açucar</option>
                <option value="Barras de Aço">Barras de Aço</option>
                <option value="Minério">Minério</option>
                <option value="Cereais">Cereais</option>
                <option value="Petróleo">Petróleo</option>
            </select>
                        </div>
                        <div class="container_amarelo">Data
                             <div class="containersete">
                <input type="date" name="envio_cargas" required>
            </div>
                        </div>
                        <div class="container_amarelo">Quantidade
                              <select name="tamanhocarga" required>
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
                </form>
                        </div>
                    </div>

                    <?php if (empty($rows)): ?>
                        


                    <?php else: ?>
                        <?php foreach ($rows as $row):
                            $id = (int)$row['id'];
                        ?>
                            <div class="flex linha-registro" style="margin-bottom:8px;">
                                <div class="container_dados" style="flex:1;">
                                    <input type="hidden" name="ids[]" value="<?= $id ?>">
                                    <input type="text" name="carga[<?= $id ?>]" value="<?= htmlspecialchars($row['carga']) ?>" />
                                </div>
                                <div class="container_dados" style="flex:1;">
                                    <input type="date" name="data[<?= $id ?>]" value="<?= htmlspecialchars($row['data']) ?>" />
                                </div>
                                <div class="container_dados" style="flex:1;">
                                    <input type="number" name="quantidade[<?= $id ?>]" value="<?= (int)$row['quantidade'] ?>" />
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div style="margin-top:16px;">
                        <button type="submit" style="background:#222;color:#f2d37c;padding:8px 14px;border-radius:6px;border:none;cursor:pointer;">
                            Salvar Alterações
                        </button>
                    </div>
                </form>

                <br><br>
            </div>

            <div class="container-menu-bar" style="position: relative; bottom: 69px;">
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
        </section>
    </main>
</body>

</html>