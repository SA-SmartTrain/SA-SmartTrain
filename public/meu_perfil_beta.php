<?php
require_once(__DIR__ . '/../db/conn.php');

session_start();

// Verifica se o usuário já está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../login/cadastro-se-dados.php');
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
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style/meu_perfil_beta.css">
    <title>SmartTrain - Meu Perfil</title>
</head>

<body>
    <div class="container-accessibility-buttons">
         <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741085445947564/notifications.png?ex=68cf3919&is=68cde799&hm=57ad55419d3e97736524f36b679b66d50383d3e22853551556bcff3bb49701ae&=&format=webp&quality=lossless " onclick="pushNot()" id="notifications">
                        <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741085810725007/dark_and_white-mode.png?ex=68cf3919&is=68cde799&hm=3d6e6cd190dd89d7cb184d2bed95aed35ba18d3866819a9aba94cf927012ff4f&=&format=webp&quality=lossless" id="dark_and_white-mode">
    </div>
    <a href="./dashboard.html" style=" text-decoration: none;"><h1 id="title">Meu Perfil</h1></a>
    <div class="profile-container">
        <div class="banner"></div>
        <div class="profile-picture-container">
            <div class="profile-picture">
                <img src="../src/assets/images/profile-login.png" alt="Profile Picture" id="profile-photo">
            </div>
        </div>

        <div class="user-info">
            <div class="username">
                <h2><?php echo $nome_usuarios ?> <i class="fas fa-chevron-down"></i></h2>
            </div>
            <div class="nickname">
                <p>@<?php echo $nome_usuarios ?></p>
            </div>
        </div>

        <button class="edit-profile" type="submit" onclick="mudarFoto()">
            <i class="fas fa-pencil-alt"></i> Editar perfil
        </button>

        <div class="info">
            <p>Informações</p>
        </div>

        <div class="info-section">
            <div class="section-title">Nome</div>
            <div class="section-content">
                <i class="fa-solid fa-user"></i> <?php echo $nome_usuarios ?>
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Email</div>
            <div class="section-content">
                <i class="fa-solid fa-inbox"></i> <?php echo $email ?>
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Cargo</div>
            <div class="section-content">
                <i class="fa-solid fa-truck-fast"></i> <?php echo $perfil?>
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Telefone</div>
            <div class="section-content">
                <i class="fa-solid fa-phone"></i> Telefone
            </div>
        </div>

        <div class="action-section">
            Endereço<i class="fas fa-chevron-right"></i>
        </div>
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
        <script src="../src/trocar_foto_meuperfil.js"></script>
</body>

</html>