<?php
session_start();
require_once __DIR__ . '/../db/conn.php'; // 🔸 Importante: conexão com o banco

// Verifica se o usuário está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../public/login/cadastre-se-page.php');
    exit;
}

// Busca as notificações ordenadas pelo ID (mais recente primeiro)
$result = $conn->query("SELECT * FROM notificacoes ORDER BY idnotificacoes DESC");
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/tela_carregamento.css">
    <link rel="stylesheet" href="../style/alertas_e_notificacoes.css">
    <title>SmartTrain - Gestão Ferroviária</title>
</head>
<body>
    <main>
        <section>
            <div class="container-accessibility-buttons">
                <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
            </div>

            <div class="containerdois">
                <div class="flex">
                    <a href="./pagina_inicial.php" style="text-decoration: none;">
                        <h1 id="title">Alertas e Notificações</h1>
                    </a>
                </div>
            </div>

            <div class="container-center">
                <!-- Barra de pesquisa -->
                <div id="abapesquisa">
                    <div class="containerum">
                        <input type="text" placeholder="Search..">
                    </div>
                </div>

                <!-- Lista de notificações cadastradas -->
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="container">
                        <div id="notificacao1">
                            <img src="../src/assets/images/info.png" alt="info">
                            <h3>ATENÇÃO!</h3>
                            <p><?= htmlspecialchars($row['observacao_notificacoes']) ?></p>
                            <div class="botao">
                                <button type="button" onclick="this.closest('.container').style.display='none'">Lido</button> <!-- Botão para marcar como lido -->
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

            <a href="adicionar_alertas.php" style="text-decoration: none;">
                <div class="adicionar-alerta" style="position: relative; bottom: 70px; left: 1320px; z-index: 999;">
                    <img src="../src/assets/images/adicionar.png" alt="" style="bottom: 20px; position: relative;">
                    <span style="color: rgb(242, 211, 124); position: relative; right: 80px;">Adicionar Alerta</span>
                </div>
            </a>

            <!-- Menu inferior -->
            <div class="container-menu-bar" style="position: relative; top: -70px; z-index: 0;">
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
                    <a href="../public/relatorios_e_analises.html"><span>Estoque</span></a>
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
