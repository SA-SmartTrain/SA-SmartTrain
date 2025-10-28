<?php
require_once '/config.php';

$conexao = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids'])) {
    $stmt = $mysqli->prepare("UPDATE cargas SET carga = ?, data = ?, quantidade = ? WHERE id = ?");
    if (!$stmt) {
        $error = 'Erro ao preparar statement: ' . $mysqli->error;
    } else {
        foreach ($_POST['ids'] as $id) {
            $id = (int)$id;
            $carga = isset($_POST['carga'][$id]) ? trim($_POST['carga'][$id]) : '';
            $data = isset($_POST['data'][$id]) && $_POST['data'][$id] !== '' ? $_POST['data'][$id] : null;
            $quantidade = isset($_POST['quantidade'][$id]) ? (int)$_POST['quantidade'][$id] : 0;

            $stmt->bind_param('ssii', $carga, $data, $quantidade, $id);
            if (!$stmt->execute()) {
                $error = 'Erro ao atualizar ID ' . $id . ': ' . $stmt->error;
                break;
            }
        }
        if ($error === '') $conexao = 'Alterações salvas com sucesso.';
        $stmt->close();
    }
}

$result = $mysqli->query("SELECT id, carga, data, quantidade FROM cargas ORDER BY id ASC");
$rows = [];
if ($result) {
    while ($r = $result->fetch_assoc()) $rows[] = $r;
    $result->free();
}
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

            <?php if ($success): ?><div class="notice success"><?=htmlspecialchars($success)?></div><?php endif; ?>
            <?php if ($error): ?><div class="notice error"><?=htmlspecialchars($error)?></div><?php endif; ?>

            <form method="post" action="">
                <div class="flex header">
                    <div class="container_amarelo">Carga</div>
                    <div class="container_amarelo">Data</div>
                    <div class="container_amarelo">Quantidade</div>
                </div>

                <?php if (empty($rows)): ?>
                    <p>Nenhum registro encontrado.</p>
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