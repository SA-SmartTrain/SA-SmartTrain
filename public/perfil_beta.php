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
$stmt = $conn->prepare("SELECT email_funcionario, telefone_funcionario, endereco_funcionario,
                        FROM funcionarios 
                        WHERE email_funcionario = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

// Valores padrão caso algum campo seja nulo
$nome_usuarios    = $dados["nome_funcionario"] ?? "Usuário";
$foto_usuarios    = $dados["foto_usuarios"] ?? "";
$telefone_usuario = $dados["telefone_funcionario"] ?? "Não definido";
$endereco_usuario = $dados["endereco_funcionario"] ?? "Não definido";
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
    <title>SmartTrain - Funcionários</title>
</head>

<body>
    <div class="container-accessibility-buttons">
        <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
        <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
    </div>
    <a href="./dashboard.html" style=" text-decoration: none;">
        <h1 id="title">Perfil- Funcionários</h1>
    </a>
    <div class="profile-container">
        <div class="banner"></div>
        <div class="profile-picture-container">
            <div class="profile-picture">
                <?php if (!empty($foto_usuarios)): ?> <!-- Verifica se há uma foto de perfil definida -->
                    <img src="<?php echo htmlspecialchars('./uploads/' . $foto_usuarios); ?>" alt="Profile Picture" id="profile-photo">
                <?php else: ?>
                    <img src="../src/assets/images/profile-login.png" alt="Profile Picture" id="profile-photo">
                <?php endif; ?>
            </div>
        </div>

        <div class="user-info">
            <div class="username">
                <h2><?php echo $nome_funcionario ?> <i class="fas fa-chevron-down"></i></h2>
            </div>
            <div class="nickname">
                <p>@<?php echo $nome_funcionario ?></p>
            </div>
        </div>

        <button class="edit-profile" type="submit" onclick="mudarFoto()" style="cursor: pointer;">
            <i class="fas fa-pencil-alt"></i> <a href="editar_meu_perfil_beta.php" style="text-decoration: none;"">Editar perfil</a>
            <form action=" excluir_dados_perfil.php" method="post"
                onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita?');"
                style="text-align:center; margin-top:10px;">
                <button type="submit"
                    style="background-color:#f0f0f0; color:black; border:none; padding:8px 12px; 
                   border-radius:5px; cursor:pointer; font-size:13px; display:flex; 
                   align-items:center; justify-content:center; gap:5px;">
                    <i class="fas fa-trash"></i> Excluir perfil
                </button>
                </form>
        </button>

        <div class="info">
            <p>Informações</p>
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