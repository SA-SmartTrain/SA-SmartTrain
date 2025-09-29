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

// Buscar nome, foto, telefone e endereço do usuário
$stmt = $conn->prepare("SELECT nome_usuarios, foto_usuarios, telefone_usuario, endereco_usuario 
                        FROM usuarios WHERE email_usuarios = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

$nome_usuarios   = $dados["nome_usuarios"] ?? "";
$foto_usuarios   = $dados["foto_usuarios"] ?? "";
$telefone_usuario = $dados["telefone_usuario"] ?? "";
$endereco_usuario = $dados["endereco_usuario"] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style/meu_perfil_beta.css">
    <title>SmartTrain - Editar Meu Perfil</title>
</head>

<body>
    <div class="container-accessibility-buttons">
        <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
        <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
    </div>

    <a href="./meu_perfil_beta.php" style=" text-decoration: none;">
        <h1 id="title">Editar perfil</h1>
    </a>

    <div class="profile-container">
        <div class="banner"></div>
        <div class="profile-picture-container">
            <div class="profile-picture">
                <?php if (!empty($foto_usuarios)): ?>
                    <img src="<?php echo htmlspecialchars($foto_usuarios); ?>" alt="Profile Picture" id="foto_usuarios">
                <?php else: ?>
                    <img src="../src/assets/images/profile-login.png" alt="Profile Picture" id="foto_usuarios">
                <?php endif; ?>
            </div>
        </div>

        <div class="user-info">
            <div class="username">
                <h2><?php echo htmlspecialchars($nome_usuarios); ?> <i class="fas fa-chevron-down"></i></h2>
            </div>
            <div class="nickname">
                <p>@<?php echo htmlspecialchars($nome_usuarios); ?></p>
            </div>
        </div>

        <div class="info">
            <p>Informações</p>
        </div>

        <!-- Formulário corrigido -->
        <form action="editar_dados_perfil.php" method="post">

            <div class="info-section">
                <div class="section-title">Nome</div>
                <div class="section-content">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nome_usuarios" value="<?php echo htmlspecialchars($nome_usuarios); ?>">
                </div>
            </div>

            <div class="info-section">
                <div class="section-title">Email</div>
                <div class="section-content">
                    <i class="fa-solid fa-inbox"></i>
                    <input type="email" name="email_usuarios" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>

            <div class="info-section">
                <div class="section-title">Telefone</div>
                <div class="section-content">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="telefone_usuario" value="<?php echo htmlspecialchars($telefone_usuario); ?>">
                </div>
            </div>

            <div class="info-section">
                <div class="section-title">Endereço</div>
                <div class="section-content">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" name="endereco_usuario" value="<?php echo htmlspecialchars($endereco_usuario); ?>">
                </div>
            </div>

            <div class="info-section">
                <div class="section-title">Imagem de Perfil</div>
                <div class="section-content">
                    <label for="foto_usuarios" style="cursor: pointer;">
                        <i class="fa-solid fa-camera"></i> Clique para enviar
                    </label>
                    <input type="file" id="foto_usuarios" name="foto_usuarios" accept="image/*" style="display: none;">
                </div>
            </div>

            <button class="edit-profile" type="submit">
                <i class="fas fa-pencil-alt"></i> Salvar mudanças
            </button>
        </form>
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