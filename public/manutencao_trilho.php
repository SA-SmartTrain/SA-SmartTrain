<?php
require_once __DIR__ . '/../db/conn.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hora = trim($_POST['hora'] ?? '');
    $periodo = ($_POST['periodo'] ?? '') === 'PM' ? 'PM' : 'AM';
    $observacao = trim($_POST['observacao'] ?? '');

    if ($hora === '') {
        $error = 'Informe a hora.';
    } elseif (!preg_match('/^\d{2}:\d{2}$/', $hora)) {
        $error = 'Hora inválida.';
    } else {
        $stmt = $mysqli->prepare("INSERT INTO manutencoes_trilhos (data_manutencao, hora, periodo, observacao, criado_em) VALUES (CURDATE(), ?, ?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param('sss', $hora, $periodo, $observacao);
            if ($stmt->execute()) {
                $success = 'Manutenção registrada com sucesso.';
            } else {
                $error = 'Erro ao salvar: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = 'Erro na preparação da query: ' . $mysqli->error;
        }
    }
}

$manutencoes = [];
$res = $mysqli->query("SELECT id, data_manutencao, hora, periodo, observacao, criado_em FROM manutencoes_trilhos ORDER BY criado_em DESC LIMIT 10");
if ($res) {
    while ($r = $res->fetch_assoc()) $manutencoes[] = $r;
    $res->free();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/manutencao_trilho.css">
    <title>SmartTrain - Manutenção dos Trilhos</title>
</head>
<body>
    <main>
        <section>
            <div class="container">
                <div class="container-accessibility-buttons">
                    <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                    <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
                </div>

                <a href="./painel_manutencao.php" style="text-decoration: none; color: #2C2C2C;">
                    <h1 id="title">Manutenção dos Trilhos</h1>
                </a>

                <?php if ($success): ?>
                    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>
                <?php if ($error): ?>
                    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <div id="topo" class="flex">
                    <h2 id="h2h2">Informe a manutenção</h2>
                </div>

                <form method="post" action="">
                    <div class="container_amarelo">
                        <div id="hora">
                            <p>Insira o horário:</p>
                            <div class="horaum">
                                <input type="time" name="hora" value="<?php echo htmlspecialchars($_POST['hora'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div id="amPM">
                            <label><input type="radio" name="periodo" value="AM" <?php if(($_POST['periodo'] ?? '') !== 'PM') echo 'checked'; ?>> AM</label>
                            <label><input type="radio" name="periodo" value="PM" <?php if(($_POST['periodo'] ?? '') === 'PM') echo 'checked'; ?>> PM</label>
                        </div>
                        <div id="buscaHora">
                            <button type="submit">Procurar / Salvar</button>
                        </div>
                    </div>

                    <div class="container_amarelo2">
                        <p>Insira observações:</p>
                        <div class="containerdois">
                            <input type="text" id="observacao" name="observacao" value="<?php echo htmlspecialchars($_POST['observacao'] ?? ''); ?>">
                            <input type="submit" value="Enviar">
                        </div>
                    </div>
                </form>

                <h3>Últimas manutenções</h3>
                <?php if (!empty($manutencoes)): ?>
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr><th>Data</th><th>Hora</th><th>Período</th><th>Observação</th><th>Registrado em</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($manutencoes as $m): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($m['data_manutencao']); ?></td>
                                    <td><?php echo htmlspecialchars($m['hora']); ?></td>
                                    <td><?php echo htmlspecialchars($m['periodo']); ?></td>
                                    <td><?php echo htmlspecialchars($m['observacao']); ?></td>
                                    <td><?php echo htmlspecialchars($m['criado_em']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Nenhuma manutenção registrada.</p>
                <?php endif; ?>

                <div class="container-menu-bar"> 
                       <div class="container-menu-bar" style="position: relative; bottom: -90px;">
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
                </div>
            </div>
        </section>
    </main>
</body>
</html>