<?php
require_once '../../db/conn.php';

session_start(); // Inicia a sessão

$error = "";

// apenas salvar no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica se o formulário foi enviado
    if (isset($_POST["login"])) { // Verifica se o botão de login foi clicado
        $nome = trim($_POST["nome"] ?? ""); // Pega o nome do formulário
        $email = trim($_POST["email"] ?? ""); // Pega o email do formulário
        $password = trim($_POST["password"] ?? ""); // Pega a senha do formulário
        $cpf = trim($_POST["cpf"] ?? "");
        $perfil = trim($_POST["perfil"] ?? "");
        $foto_usuarios = '../src/assets/images/profile-login.png'; // Define a foto padrão
    }

    if (strlen($password) < 8) {
        $error = "A senha deve ter pelo menos 8 caracteres.";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = "A senha deve conter pelo menos uma letra maiúscula.";
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error = "A senha deve conter pelo menos uma letra minúscula.";
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "A senha deve conter pelo menos um número.";
    } elseif (!preg_match('/[\W_]/', $password)) {
        $error = "A senha deve conter pelo menos um caractere especial (ex: @, #, $, %).";
    } else {
        // Criptografa a senha antes de salvar
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Verifica se o email já está cadastrado
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email_usuarios = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verifica se o cpf já está cadastrado
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE cpf_usuarios = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $resultado2 = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $error = "Email já cadastrado.";
        } elseif ($resultado2->num_rows > 0) {
            $error = "CPF já cadastrado."; // Mensagem de erro
        } else {
            // Insere o novo usuário no banco de dados
            $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuarios, email_usuarios, senha_usuarios, cpf_usuarios, perfil, foto_usuarios) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nome, $email, $passwordHash, $cpf, $perfil, $foto_usuarios);


            if ($stmt->execute()) {
                $_SESSION["email"] = $email;
                $_SESSION["name"] = $nome;
                header('Location: cadastre-se-page.php');
                exit;
            } else {
                $error = "Erro ao cadastrar. Tente novamente.";
            }
        }
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
    <title>SmartTrain - Cadastro</title>
</head>

<body>
    <h2>Seja bem-vindo a SmartTrain</h2>


    <div class="row">
        <div class="col-md-6">
            <img src="../../src/assets/images/logo-smarttrain.png" alt="Imagem de Cadastro" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h3>Cadastre-se</h3>
            <p>Crie sua conta para começar a usar a SmartTrain!</p>
        </div>
    </div>


    <form method="POST" action="cadastro-se-dados.php" class="m-3"> <!-- Formulário de login feito com bootstrap -->
        <fieldset>

            <div class="mb-2">
                <label for="disabledTextInput" class="form-label">Nome:</label>
                <input type="nome" id="nome" class="form-control" name="nome" required>
            </div>

            <div class="mb-2">
                <label for="disabledTextInput" class="form-label">Email:</label>
                <input type="email" id="email" class="form-control" name="email" required>
            </div>

            <div class="mb-2">
                <label for="disabledTextInput" class="form-label">CPF:</label>
                <input type="cpf" id="cpf" class="form-control" name="cpf" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <div class="input-group">
                    <input type="password" id="password" class="form-control" name="password" required minlength="8">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                        <span id="eyeIcon">&#128065;</span>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="perfil" class="form-label">Perfil</label>
                <select class="form-select" name="perfil" id="perfil" required>
                    <option value="usuario">Usuário</option>
                    <option value="gestor">Gestor</option>
                    <option value="administrador">Administrador</option>
                </select>
            </div>

             <div class="mb-3" style="background-color: #F0F0F0;">
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

            <button type="submit" class="btn btn-warning" name="login">Cadastre-se aqui</button>
            <a href="cadastre-se-page.php" class="btn btn-link" style="color:rgb(242, 211, 124);">Já possui uma conta</a>
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