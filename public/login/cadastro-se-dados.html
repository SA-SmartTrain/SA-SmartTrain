<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ini_array = parse_ini_file('../../bd/config.ini', true); // Ajuste o caminho
    $dbHost = $ini_array["database"]["host"];
    $dbUser = 'smarttrain';
    $dbPass = $ini_array["database"]["password"];
    $dbName = 'smarttrain';
    $dbPort = 6306;

    $conexao = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

    // Verifica a conexão
    if (!$conexao) {
        die("Erro de conexão: " . mysqli_connect_error());
    }

    // Pegando os valores corretos dos campos
    $usuario = $_POST['username'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['password'];

    // Insere no banco
    $result = mysqli_query($conexao, "INSERT INTO cadastro_usuario (usuario, email, cpf, senha) 
              VALUES ('$usuario', '$email', '$cpf', '$senha')");

    if ($result) {
        echo "Cadastro realizado com sucesso!";
    } 

    mysqli_close($conexao);
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
                            <input type="username" name="username" id="usuario" required>
                        </div>
                        <br>
                        <div class="container-box-login">
                            <input type="username" name="email" id="email" required>
                        </div>
                        <br>
                        <div class="container-box-login">
                            <input type="CPF" name="cpf" id="cpf" required>
                        </div>
                        <br>
                        <div class="container-box-login">
                            <input type="password" name="password" id="senha" required>
                        </div>
                        <div class="container-forgotten-password">
                            <input type="checkbox" name="esqueceu_senha" id="esqueceu_senha">
                            <span>Salvar Senha</span>
                            <a href="/public/login/cadastre-se-page.html" id="possui-uma-conta"><span>Ja possui uma
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