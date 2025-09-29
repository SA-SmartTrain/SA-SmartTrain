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

// Buscar nome, foto, telefone, endereço e perfil do usuário
$stmt = $conn->prepare("SELECT nome_usuarios, foto_usuarios, telefone_usuario, endereco_usuario, perfil 
                        FROM usuarios 
                        WHERE email_usuarios = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

// Valores padrão caso algum campo seja nulo
$nome_usuarios    = $dados["nome_usuarios"] ?? "Usuário";
$foto_usuarios    = $dados["foto_usuarios"] ?? "";
$telefone_usuario = $dados["telefone_usuario"] ?? "Não definido";
$endereco_usuario = $dados["endereco_usuario"] ?? "Não definido";
$perfil           = $dados["perfil"] ?? "Não definido";

$stmt->close();

$conn->close();
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
    <a href="./dashboard.html" style=" text-decoration: none;">
        <h1 id="title">Meu Perfil</h1>
    </a>
    <div class="profile-container">
        <div class="banner"></div>
        <div class="profile-picture-container">
            <div class="profile-picture">
                <?php if (!empty($foto_usuarios)): ?> <!-- Verifica se há uma foto de perfil definida -->
                    <img src="<?php echo htmlspecialchars($foto_usuarios); ?>" alt="Profile Picture" id="profile-photo">
                <?php else: ?>
                    <img src="../src/assets/images/profile-login.png" alt="Profile Picture" id="profile-photo">
                <?php endif; ?>
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

        <button class="edit-profile" type="submit" onclick="mudarFoto()" style="cursor: pointer;">
            <i class="fas fa-pencil-alt"></i> <a href="editar_meu_perfil_beta.php" style="text-decoration: none;"">Editar perfil</a>
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
                <i class="fa-solid fa-truck-fast"></i> <?php echo $perfil ?>
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Telefone</div>
            <div class="section-content">
                <i class="fa-solid fa-phone"></i> <?php echo $telefone_usuario ?>
            </div>
        </div>

        <div class="info-section">
            <div class="section-title">Endereço</div>
            <div class="section-content">
                <i class="fa-solid fa-phone"></i> <?php echo $endereco_usuario ?>
            </div>
        </div>
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
    <script src="../src/trocar_foto_meuperfil.js"></script>
</body>

</html>