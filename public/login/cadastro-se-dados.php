<?php

if (isset($_POST['submit'])) {
    // Declarando as variáveis para a tabela BD
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // Incluindo conexão
    include_once('/bd/conexao.php');

    // Result = Levar todos os dados do PHP para a tabela no BD
    $result = mysqli_query($conexao, "INSERT INTO cadastro_usuario(usuario, email, cpf, senha) 
    VALUES ('$usuario', '$email', '$cpf', '$senha')");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8"> <!-- Suporte a caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade em dispositivos móveis -->

    <!-- Ícone da aba (favicon) -->
    <link rel="shortcut icon" href="/src/assets/logo/favicon.ico" type="image/x-icon">

    <!-- Estilos CSS globais e específicos da página -->
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../login/cadastro-se-dados.css">

    <!-- Título da aba -->
    <title>SmartTrain - Cadastre-se</title>
</head>

<body>
    <main>
        <section>
            <!-- Container adaptável para dispositivos móveis -->
            <div class="container-size-mobile">

                <!-- Barra amarela decorativa -->
                <div class="container-bar-yellow"></div>

                <!-- Container principal do formulário -->
                <div class="container">

                    <!-- Imagem de faixa amarela (design visual) -->
                    <div class="container-wave-yellow">
                        <img src="/src/assets/images/yellow.png" alt="">
                    </div>

                    <!-- Texto de boas-vindas e instruções -->
                    <div class="container-text-cadastre-se">
                        <h2>Seja Bem Vindo!</h2>
                        <span style="position: relative; right: 110px;">
                            Insira Nome de Usuário, Email, CPF e Senha para prosseguir:
                        </span>
                    </div>

                    <!-- Formulário de cadastro -->
                    <form action="/public/login/cadastro-se-dados.php" method="POST" id="">

                        <!-- Campo: Nome de Usuário -->
                        <div class="container-box-login">
                            <input type="username" name="username" id="usuario" required>
                        </div>
                        <br>

                        <!-- Campo: Email (obs: ID e name repetidos, veja nota abaixo) -->
                        <div class="container-box-login">
                            <input type="username" name="username" id="email" required>
                        </div>
                        <br>

                        <!-- Campo: CPF -->
                        <div class="container-box-login">
                            <input type="CPF" name="CPF" id="cpf" required>
                        </div>
                        <br>

                        <!-- Campo: Senha -->
                        <div class="container-box-login">
                            <input type="password" name="password" id="senha" required>
                        </div>

                        <!-- Opções adicionais: salvar senha e link para login -->
                        <div class="container-forgotten-password">
                            <input type="checkbox" name="esqueceu_senha" id="esqueceu_senha">