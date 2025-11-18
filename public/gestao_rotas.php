<?php
require_once __DIR__ . '/../db/conn.php';

$rotas = [];
$sensores = [];
$alertas = [];

if (isset($mysqli) && $mysqli) {
    
    $result_rotas = $mysqli->query("SELECT idrotas, numero_linha, horario_saida, status FROM rotas ORDER BY horario_saida ASC LIMIT 5");
    if ($result_rotas) {
        while ($row = $result_rotas->fetch_assoc()) {
            $rotas[] = $row;
        }
    }


    $result_sensores = $mysqli->query("SELECT idsensores, tipo_sensor, localizacao, data_sensor FROM sensores ORDER BY data_sensor DESC LIMIT 3");
    if ($result_sensores) {
        while ($row = $result_sensores->fetch_assoc()) {
            $sensores[] = $row;
        }
    }

    
    $result_alertas = $mysqli->query("SELECT idalertas, tipo_alerta, descricao_alerta FROM alertas ORDER BY data_alerta DESC LIMIT 3");
    if ($result_alertas) {
        while ($row = $result_alertas->fetch_assoc()) {
            $alertas[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/gestao_rotas.css">
    <title>SmartTrain - Gestão de Rotas</title>
</head>

<body>
    <main>
        <section>
            <div class="container">
                <div id="topo" class="flex">
                    <div class="seta">
                        <img src="../src/assets/images/seta.png">
                    </div>

                    <a href="./pagina_inicial.php" style="text-decoration: none;">
                        <h1 id="title">Gestão de Rotas</h1>
                    </a>
                </div>

                <div class="flex-containers">
                    <!-- Seção de Horários -->
                    <div class="container_amarelo">
                        <h2>Horários</h2>
                        <div class="flex">
                            <div class="relogio">
                                <img src="../src/assets/images/relogio.png">
                            </div>
                            <div class="container_interno">
                                <?php if (!empty($rotas)): ?>
                                    <?php foreach ($rotas as $rota): ?>
                                        <div class="flex">
                                            <div class="container_horario">
                                                <p><?php echo date('M d, Y'); ?></p>
                                            </div>
                                            <div class="container_horario">
                                                <p><?php echo htmlspecialchars($rota['horario_saida']); ?></p>
                                            </div>
                                            <div class="container_horario">
                                                <p><?php echo htmlspecialchars($rota['numero_linha']); ?></p>
                                            </div>
                                        </div>
                                        <br>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Nenhuma rota disponível</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <!-- Seção de Status de Sensores -->
                    <div class="container_amarelo">
                        <h2>Status</h2>
                        <div class="flex">
                            <?php if (!empty($sensores)): ?>
                                <?php foreach ($sensores as $sensor): ?>
                                    <div class="container_status">
                                        <h3><?php echo htmlspecialchars($sensor['tipo_sensor']); ?></h3>
                                        <p><strong>Local:</strong> <?php echo htmlspecialchars($sensor['localizacao']); ?></p>
                                        <p><strong>Data:</strong> <?php echo htmlspecialchars($sensor['data_sensor']); ?></p>
                                    </div>
                                    <br>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Nenhum sensor disponível</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <br><br>

                    <!-- Seção de Alertas -->
                    <div class="container_amarelo" id="alert-aaa">
                        <h2>Alertas</h2>
                        <?php if (!empty($alertas)): ?>
                            <?php foreach ($alertas as $alerta): ?>
                                <div class="alerta">
                                    <div class="flex">
                                        <img src="../src/assets/images/alerta.png">
                                        <div id="container_alertas">
                                            <h3><?php echo htmlspecialchars($alerta['tipo_alerta']); ?></h3>
                                            <p><?php echo htmlspecialchars($alerta['descricao_alerta']); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Nenhum alerta no momento</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="container-menu-bar">
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

        <div class="container-accessibility-buttons">
            <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
            <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
        </div>
    </main>
</body>

</html>