<?php
require_once(__DIR__ . '/../db/conn.php');

session_start();

// Verifica se o usuário já está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../public/login/cadastre-se-page.php'); // Redireciona para a página de login
    exit;
}

$email = $_SESSION["email_usuarios"];
$perfil_usuarios = $_SESSION["perfil"] ?? '';


$stmt = $conn->prepare("SELECT nome_usuarios, perfil 
                        FROM usuarios 
                        WHERE email_usuarios = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/pagina_inicial.css">
    <link rel="stylesheet" href="../style/global/container-size-mobile.css">
    <title>SmartTrain - Página Inicial</title>
</head>

<body>
    <main>
        <section>
            <div class="container-size-mobile">
                <div class="container">
                    <div class="container-accessibility-buttons">
                        <a onclick="abrirModal()">
                            <img src="../src/assets/images/sair.png" alt="exit" style="cursor: pointer;">
                        </a>
                        <div id="modalOverlay" class="overlay" onclick="fecharModal()">
                            <div class="modal" onclick="event.stopPropagation()">
                                <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome_usuarios); ?></p>

                                <?php if ($perfil_usuarios === 'administrador'): ?>
                                    <p><a href="../public/admin/admin.php">Admin</a></p>
                                <?php endif; ?>

                                <p><a href="../public/login/logout.php" style="color: rgb(242, 211, 124);">Desconectar</a></p>
                            </div>
                        </div>
                        <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                        <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
                    </div>
                    <h1>Página Inicial</h1>
                    <div class="container-sections">
                        <a href="../public/dashboard.html">
                            <p>Dashboard Geral</p>
                        </a>
                        <hr>
                        <a href="../public/gestao_rotas.html">
                            <p>Gestão de Rotas</p>
                        </a>
                        <hr>
                        <a href="../public/monitoramento_cargas.html">
                            <p>Monitoramento de Cargas</p>
                        </a>
                        <hr>
                        <a href="../public/painel_manutencao.php">
                            <p>Painel de Manutenção</p>
                        </a>
                        <hr>
                        <a href="../public/relatorios_e_analises.html">
                            <p>Relatórios e Análises</p>
                        </a>
                        <hr>
                        <a href="../public/alertas_e_notificacoes.php">
                            <p>Alertas e Notificações</p>
                        </a>
                        <hr>
                        <a href="../public/hub_de_gerenciamentos.php">
                            <p>Hub de Gerenciamentos</p>
                        </a>
                        <hr>
                    </div>
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
                            <a href="../public/relatorios_e_analises.html"><span>Estoque</span></a>
                        </div>
                        <div class="sections-menu-bar" id="press-effect">
                            <div id="funcionarios"><img src="../src/assets/images/funcionarios-bar.png" alt=""></div>
                            <a href="../public/funcionarios.html"><span>Funcionários</span></a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
</body>

<style>
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal {
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        text-align: center;
        min-width: 250px;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<script src="../src/template_notificacao.js"></script>
<script src="../src/logout.js"></script>

</html>