<?php
require_once '../../db/conn.php';

session_start();

if (isset($_SESSION["email_usuarios"])) { // Verifica se o usuário já está logado
    header('Location: ../public/pagina_inicial.html'); // Redireciona para a página inicial
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se o usuário existe no banco de dados
    $stmt = $conn->prepare("SELECT idusuarios, senha_usuarios FROM usuarios WHERE nome_usuarios = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        // Login bem-sucedido, inicia a sessão
        $_SESSION["email_usuarios"] = $username;
        $_SESSION["idusuarios"] = $id;
        header('Location: ../public/pagina_inicial.html'); // Redireciona para a página inicial
        exit();
    } else {
        $error = 'Nome de usuário ou senha incorretos.';
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../login/cadastre-se-page.css">
    <title>SmartTrain - Cadastre-se</title>
</head>

<body>
    <main>
        <section>
            <div class="container-bar-yellow"></div>
            <div class="container">
                <div class="container-wave-yellow">
                    <img src="/src/assets/images/yellow.png" alt="">
                </div>
                <div class="container-text-cadastre-se">
                    <h2>Seja Bem Vindo!</h2>
                    <span>Insira Nome de Usuário e Senha para prosseguir:</span> <!--Revisar pra quebrar linha-->
                </div>
                <div class="container-box-login">
                    <div class="container-icon">
                        <img src="/src/assets/images/funcionarios-bar.png" alt="">
                    </div>
                    <input type="username" name="username" id="usuario" placeholder="admin" required>
                </div>
                <br>
                <div class="container-box-login">
                    <input type="password" name="password" id="senha" placeholder="admin" required>
                    <div class="container-icon-password">
                        <img src="/src/assets/images/password.png" alt="">
                    </div>
                </div>
                <div class="container-forgotten-password">
                    <input type="checkbox" name="esqueceu_senha" id="esqueceu_senha">
                    <span>Salvar Senha</span>
                    <a href="/public/login/cadastro-se-dados.html"><span>Não possui uma conta?</span></a>
                </div>
                <div class="container-login-profile">
                    <button type="submit" onclick="loginAdmin()"><a
                            href=""><span>Login</span></a></button>
                </div>
                <div class="container-social-media">
                    <div class="social-media">
                        <img src="/src/assets/images/social-media/facebook.png" alt="">
                    </div>
                    <div class="social-media">
                        <a
                            href="https://accounts.google.com/AddSession/signinchooser?service=accountsettings&continue=https%3A%2F%2Fmyaccount.google.com%2F%3Futm_source%3Dsign_in_no_continue%26pli%3D1&ec=GAlAwAE&hl=pt_BR&authuser=0&ddm=1&flowName=GlifWebSignIn&flowEntry=AddSession"><img
                                src="/src/assets/images/social-media/google.png" alt=""></a>
                    </div>
                    <div class="social-media">
                        <img src="/src/assets/images/social-media/linkdin.png" alt="">
                    </div>
                </div>
                <div class="container-login-logo_sa">
                    <img src="/src/assets/images/logo-smarttrain-apagada.png" alt="">
                </div>
            </div>
        </section>
    </main>
</body>
<script src="/src/login-admin.js"></script>

</html>