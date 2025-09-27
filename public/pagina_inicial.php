<?php
require_once(__DIR__ . '/../db/conn.php');

session_start();

// Verifica se o usuário já está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../public/login/cadastre-se-page.php'); // Redireciona para a página de login
    exit;
}

// Pega o email da sessão
$email = $_SESSION["email_usuarios"];

// Busca o nome no banco
$stmt = $conn->prepare("SELECT nome_usuarios FROM usuarios WHERE email_usuarios = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();
$nome_usuarios = $dados["nome_usuarios"];
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
                                <p><strong>Nome:</strong> <?php echo $nome_usuarios ?></p>
                                <p><a href="../public/admin/admin.php" style="color: rgb(242, 211, 124);">Admin</a></p>
                                <p><a href="../public/login/logout.php" style="color: rgb(242, 211, 124);">Desconectar</a></p>
                            </div>
                        </div>
                        <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741085445947564/notifications.png?ex=68cf3919&is=68cde799&hm=57ad55419d3e97736524f36b679b66d50383d3e22853551556bcff3bb49701ae&=&format=webp&quality=lossless " onclick="pushNot()" id="notifications">
                        <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741085810725007/dark_and_white-mode.png?ex=68cf3919&is=68cde799&hm=3d6e6cd190dd89d7cb184d2bed95aed35ba18d3866819a9aba94cf927012ff4f&=&format=webp&quality=lossless" id="dark_and_white-mode">
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
                        <a href="../public/manutencao_trilho.html">
                            <p>Manutenção dos Trilhos</p>
                        </a>
                        <hr>
                        <a href="../public/relatorios_e_analises.html">
                            <p>Relatórios e Análises</p>
                        </a>
                        <hr>
                        <a href="../public/alertas_e_notificacoes.html">
                            <p>Alertas e Notificações</p>
                        </a>
                        <hr>
                        <a href="../public/cadastro_de_cargas.html">
                            <p>Cadastro de Cargas</p>
                        </a>
                        <hr>
                    </div>
                    <div class="container-menu-bar">
                        <div class="sections-menu-bar" id="press-effect">
                            <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741387947671582/inicio-bar.png?ex=68cf3961&is=68cde7e1&hm=c7185d30797b701fe8d859c923d089c36c4d1dc65f66c5ec33965ab8278edd6a&=&format=webp&quality=lossless" alt="">
                            <div id="incio">
                                <a href="../public/pagina_inicial.php"><span>Início</span></a>
                            </div>
                        </div>
                        <div class="sections-menu-bar" id="press-effect">
                            <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741388589404220/menu-bar.png?ex=68cf3961&is=68cde7e1&hm=8ba9f963bf5c804e92aa79f8056e4d2c4804a2594df7ce9ba5863582be6258e6&=&format=webp&quality=lossless" alt="">
                            <a href="../public/documentacoes.html"><span>Menu</span></a>
                        </div>
                        <div class="sections-menu-bar" id="press-effect">
                            <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741388912361765/estoque-bar.png?ex=68cf3962&is=68cde7e2&hm=2f81ca0a243c1ba493fa2b154e76d3483cd3a2aee8b28787247a1d77eb169de1&=&format=webp&quality=lossless" alt="">
                            <a href="../public/relatorios_e_analises.html"><span>Estoque</span></a>
                        </div>
                        <div class="sections-menu-bar" id="press-effect">
                            <div id="funcionarios"><img src="https://media.discordapp.net/attachments/1418730196617396327/1418741387599548526/funcionarios-bar.png?ex=68cf3961&is=68cde7e1&hm=8129bcfc6bd85e81d312f7dfd7ff8ce81bd21d75925fcd2b0a43e9f594873ccd&=&format=webp&quality=lossless" alt=""></div>
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