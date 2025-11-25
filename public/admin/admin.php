<?php
include_once __DIR__ . '/../../db/conn.php';

session_start();

// Verifica se o usuário já está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../public/login/cadastre-se-page.php'); // Redireciona para a página de login
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/SA-SmartTrain/src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/pagina_inicial.css">
    <link rel="stylesheet" href="../style/global/container-size-mobile.css">
    <title>SmartTrain - Admin view</title>
</head>

<body>
    <div class="container-size-mobile">
        <div class="container">
            <div class="container-accessibility-buttons">
                <img src="../../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                <img src="../../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
            </div>
            <h1>Admin</h1>
            <h1 style="position: relative; font-family: Arial;">
                Bem-vindo, <?php echo htmlspecialchars($nome_usuarios); ?>!
            </h1>
            <h3 style="font-family: Arial; position: relative; left: 35px; font-weight: 400;">
                Controle central de usuários e sensores do Sistema de Gestão Ferroviária SmartTrain.
            </h3>
            <div class="container-sections">
                <a href="../admin/visualizar_user.php">
                    <p>Visualizar Usuários</p>
                </a>
                <hr>
                <a href="../admin/">
                    <p>Visualizar Sensores MQTT Ativos</p>
                </a>
                <hr>
            </div>
        </div>
    </div>
</body>
<style>
    * {
        color: #2C2C2C;
    }

    body {
        background-color: #F0F0F0;
        overflow: hidden;
    }

    .container-accessibility-buttons {
        display: flex;
        position: relative;
        top: 50px;
        margin-left: 1700px;
        width: 100px;
        height: 30px;
        gap: 1px;
        z-index: 1;
    }

    .container-accessibility-buttons img {
        margin-left: 30px;
        width: 30px;
        height: 30px;
    }


    h1 {
        margin-left: 35px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 26px;
        font-weight: bold;
    }

    .container-menu-bar {
        position: relative;
        margin-top: 29.6%;
        display: flex;
        justify-content: center;
        width: 100vw;
        height: 60px;
        gap: 350px;
    }

    .sections-menu-bar {
        position: relative;
        left: 6px;
        width: 50px;
        height: 50px;
        margin-left: 10px;
        opacity: 0.3;
    }

    .sections-menu-bar span {
        position: relative;
        left: 5px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 600;
    }

    .sections-menu-bar a {
        text-decoration: none;
    }

    .container-menu-bar img {
        width: 100%;
    }

    #funcionarios {
        position: relative;
        left: 20px;
    }

    #press-effect:hover {
        opacity: 1;
    }

    #notifications:hover {
        cursor: pointer;
    }

    .container-sections {
        position: relative;
        top: 30px;
        margin-left: 35px;
    }

    .container-sections p {
        position: relative;
        top: 20px;
        font-size: 25px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .container-sections hr {
        position: relative;
        right: 1480px;
        width: 270px;
        height: 1px;
        border: 1px;
        border-top: 3px solid rgb(242, 211, 124);
        background-color: rgb(242, 211, 124);
        border-radius: 80px;
        margin-right: 120px;
    }

    .container-sections a {
        text-decoration: none;
    }

    @media screen and (max-width: 960px) {

        .container-accessibility-buttons {
            position: relative;
            right: 1400px;
        }

        .container-sections hr {
            position: relative;
            right: 25px;
        }

        .container-menu-bar {
            position: relative;
            top: 30px;
            gap: 55px;
            right: 30px;
        }


    }

    @media screen and (max-width: 480px) {
        body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            background: #F0F0F0;
        }

        .container-accessibility-buttons {
            top: 32px;
            margin-left: 0;
            width: 100%;
            gap: 16px;
            justify-content: flex-end;
            padding-right: 18px;
            position: absolute;
            right: 0;
        }

        .container-accessibility-buttons img {
            margin-left: 0;
            width: 26px;
            height: 26px;
        }

        h1 {
            margin-left: 0;
            padding-left: 18px;
            font-size: 22px;
            margin-top: 32px;
            margin-bottom: 0;
        }

        .container-sections {
            margin-left: 0;
            top: 60px;
            padding: 0 18px;
        }

        .container-sections a {
            display: block;
        }

        .container-sections p {
            top: 0;
            font-size: 22px;
            margin-bottom: 0;
            margin-top: 28px;
            font-weight: 400;
            text-align: left;
        }

        .container-sections hr {
            right: 0;
            width: 90%;
            margin: 4px 0 0 0;
            border: none;
            border-top: 3px solid rgb(242, 211, 124);
            background: rgb(242, 211, 124);
            border-radius: 80px;
            height: 0;
            margin-right: 0;
        }

        .container-menu-bar {
            position: relative;
            top: 517px;
            gap: 40px;
        }

        .container-menu-bar img {
            left: 5px;
            width: 46px;
            height: 46px;
        }
    }
</style>

</html>