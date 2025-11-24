<?php
require_once __DIR__ . '/../db/conn.php';

$trens = [];
$sensores = [];

if (isset($mysqli) && $mysqli) {


    $result_trens = $mysqli->query("SELECT idtrens, identificador_trem, carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem FROM trens ORDER BY idtrens DESC LIMIT 5");
    if ($result_trens) {
        while ($row = $result_trens->fetch_assoc()) {
            $trens[] = $row;
        }
    }


    $result_sensores = $mysqli->query("SELECT idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor FROM sensores ORDER BY data_sensor DESC LIMIT 5");
    if ($result_sensores) {
        while ($row = $result_sensores->fetch_assoc()) {
            $sensores[] = $row;
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
                        <img src="../src/assets/images/seta.png" alt="Seta">
                    </div>
                    <a href="./pagina_inicial.php" style="text-decoration: none;">
                        <h1 id="title">Gestão de Rotas</h1>
                    </a>
                </div>

                <div class="flex-containers">
                    <!-- Seção de Trens -->
                    <div class="container_amarelo">
                        <h2>Trens Cadastrados</h2>
                        <div class="flex">
                            <div class="relogio">
                                <img src="../src/assets/images/relogio.png" alt="Relógio">
                            </div>
                            <div class="container_interno">
                                <?php if (!empty($trens)): ?>
                                    <?php foreach ($trens as $trem): ?>
                                        <div class="flex">
                                            <div class="container_horario">
                                                <p><strong>ID:</strong> <?php echo htmlspecialchars($trem['identificador_trem']); ?></p>
                                            </div>
                                            <div class="container_horario">
                                                <p><strong>Carga:</strong> <?php echo htmlspecialchars($trem['carga_trem']); ?></p>
                                            </div>
                                            <div class="container_horario">
                                                <p><strong>Capacidade:</strong> <?php echo htmlspecialchars($trem['capacidade_trem']); ?></p>
                                            </div>
                                            <div class="container_horario">
                                                <p><strong>Vagões:</strong> <?php echo htmlspecialchars($trem['vagoes_trem']); ?></p>
                                            </div>
                                            <div class="container_horario">
                                                <p><strong>Estado:</strong> <?php echo htmlspecialchars($trem['estado_trem']); ?></p>
                                            </div>
                                            <div class="container_horario">
                                                <p><strong>Velocidade:</strong> <?php echo htmlspecialchars($trem['velocidade_trem']); ?></p>
                                            </div>
                                        </div>
                                        <br>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p style="background-color: rgb(242, 211, 124);">Nenhum trem disponível</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <!-- Seção de Sensores -->
                    <div class="container_amarelo">
                        <h2>Sensores Cadastrados</h2>
                        <div class="flex">
                            <?php if (!empty($sensores)): ?>
                                <?php foreach ($sensores as $sensor): ?>
                                    <div class="container_status" style="display: flex; max-width: 550px; max-height: 60px;">

                                        <h3 style="position: relative; bottom: 10px;"><?php echo htmlspecialchars($sensor['tipo_sensor']); ?></h3>
                                        <p><strong>Localização:</strong> <?php echo htmlspecialchars($sensor['localizacao_sensor']); ?></p>
                                        <p><strong>Data:</strong> <?php echo htmlspecialchars($sensor['data_sensor']); ?></p>
                                        <p><strong>Observação:</strong> <?php echo htmlspecialchars($sensor['observacao_sensor']); ?></p>
                                    </div>
                                    <br>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Nenhum sensor disponível</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container-menu-bar" style="position: relative; top: 330px; right: -10px;">
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