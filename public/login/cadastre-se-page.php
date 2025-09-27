<?php
require_once '../../db/conn.php';

session_start();

if (isset($_SESSION["email_usuarios"])) { // Verifica se o usuário já está logado
    header('Location: ../pagina_inicial.php'); // Redireciona para a página inicial
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    // Busca só pelo email
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email_usuarios = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $dados = $resultado->fetch_assoc();

        // Verifica a senha com o hash do banco
        if (password_verify($password, $dados["senha_usuarios"])) {
            $_SESSION["email_usuarios"] = $dados["email_usuarios"];
            $_SESSION["nome_usuarios"] = $dados["nome_usuarios"]; // cuidado com o nome da coluna
            header('Location: ../pagina_inicial.php');
            exit;
        } else {
            $error = "Email ou senha inválidos.";
        }
    } else {
        $error = "Email ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="shortcut icon" href=".../src/assets/logo/favicon.ico" type="image/x-icon">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>SmartTrain - Login</title>
</head>

<body>
    <h2>Seja bem-vindo a SmartTrain</h2>

    <div class="row">
        <div class="col-md-6">
            <img src="../../src/assets/images/logo-smarttrain.png" alt="Imagem de Cadastro" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h3>Login</h3>
            <p>Entre em sua conta para começar a usar a SmartTrain!</p>
        </div>
    </div>

    <form method="POST" action="cadastre-se-page.php" class="m-3"> <!-- Formulário de login feito com bootstrap -->
        <fieldset>
            <div class="mb-2">
                <label for="disabledTextInput" class="form-label">Email:</label>
                <input type="email" id="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <div class="input-group">
                    <input type="password" id="password" class="form-control" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                        <span id="eyeIcon">&#128065;</span>
                    </button>
                </div>
            </div>
            
            <div class="mb-3" style=background-color: #F0F0F0;>
                <div class="g-recaptcha" data-sitekey="6Lft5tYrAAAAAB4P6uSdIptR_pXn7fkO0HH04Xtk"></div>
             </div>

            <div class="mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="disabledFieldsetCheck">
                    <label class="form-check-label" for="disabledFieldsetCheck">
                        Manter-me conectado
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-warning" name="login">Login</button>
            <a href="../login/cadastro-se-dados.php" class="btn btn-link" style="color:rgb(242, 211, 124);">Cadastre-se aqui</a>
            <?php
            if ($error) {
                echo '<div class="alert alert-danger mt-3" role="alert">' . htmlspecialchars($error) . '</div>';
            }
            ?>
        </fieldset>
    </form>
</body>
<style>
    body {
        margin: 20px;
        background-color: #F0F0F0;
    }

    input.form-control,
    select.form-select {
        background-color: #f0f0f0;
    }
</style>
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        // Alterna o ícone (olho aberto/fechado)
        eyeIcon.textContent = type === 'password' ? '\u{1F441}' : '\u{1F441}\u{200D}\u{1F5E8}';
    });
</script>

</html>