<?php
require_once '../../db/conn.php';

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $cpf = substr(preg_replace('/\D/', '', $_POST['cpf']), 0, 14);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $passwordError = "";

    // Validação de senha
    if ($password != $confirmPassword) {
        $passwordError .= "As senhas não coincidem.\n";
    }
    else if (strlen($password) < 8) {
        $passwordError .= "A senha deve ter no mínimo 8 caracteres.\n";
    } else if (!empty($passwordError)) {
        echo nl2br($passwordError); // Exibe os erros formatados
    } else {

        // Verifica se o email ou CPF já estão cadastrados
        $stmt = $conn->prepare("SELECT idusuarios FROM usuarios WHERE email_usuarios = ? OR cpf_usuarios = ?");
        $stmt->bind_param("ss", $email, $cpf);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Email ou CPF já cadastrado.';
        } else {
            // Insere o novo usuário no banco de dados
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuaruis, email_usuarios, cpf_usuarios, senha_usuarios) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $cpf, $hashedPassword);

            if ($stmt->execute()) {
                // Registro bem-sucedido, redireciona para a página de login
                header('Location: public/login/cadastre-se-page.php');
                exit();
            } else {
                $error = 'Erro ao cadastrar. Tente novamente.';
            }
        }

        $stmt->close();
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../login/cadastro-se-dados.css">
    <title>SmartTrain - Cadastre-se</title>
</head>

<body>
    <main>
        <section>
            <div class="container-size-mobile">
                <div class="container-bar-yellow"></div>
                <div class="container">
                    <div class="container-wave-yellow">
                        <img src="/src/assets/images/yellow.png" alt="">
                    </div>
                    <div class="container-text-cadastre-se">
                        <h2>Seja Bem Vindo!</h2>
                        <span style="position: relative; right: 110px;">Insira Nome de Usuário, Email, CPF e Senha para
                            prosseguir:</span>
                    </div>
                    <form action="/SA-SmartTrain/public/login/cadastro-se-dados.php" method="POST">
                        <div class="container-box-login">
                            <input type="username" name="username" id="usuario" placeholder="Nome" required>
                        </div>
                        <br>
                        <div class="container-box-login">
                            <input type="username" name="email" id="email" placeholder="Email" required>
                        </div>
                        <br>
                        <div class="container-box-login">
                            <input type="text" name="cpf" id="cpf" placeholder="CPF" maxlength="14" pattern="\d{11,14}" required>
                        </div>
                        <br>
                        <div class="container-box-login">
                            <input type="password" name="password" id="senha" placeholder="Senha" required>
                        </div>
                        <br>
                        <div class="container-box-login">
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirme a senha" required>
                        </div>
                        <div class="container-forgotten-password">
                            <input type="checkbox" name="esqueceu_senha" id="esqueceu_senha">
                            <span>Salvar Senha</span>
                            <a href="/public/login/cadastre-se-page.html" id="possui-uma-conta"><span>Já possui uma
                                    conta?</span></a>
                        </div>
                        <div class="container-login-profile">
                            <button type="submit" id="iii">Cadastre-se aqui</button>
                        </div>
                    </form>
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
        </div>
    </main>
</body>

</html>