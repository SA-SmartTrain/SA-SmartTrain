<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/cadastro_sensores.css">
    <title>SmartTrain - Gerenciamento de Sensores</title>
</head>

<body>
    <section>
        <div class="container">
            <div class="container-accessibility-buttons">
                <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
            </div>
        </div>

        <div class="containerdois flex">
            <div>
                <a href="./gerenciamento_sensores.php" style="text-decoration: none;">
                    <h1 id="title">Alertas e Notificações</h1>
                </a>
            </div>
        </div>
    </section>

    <h2>Informações</h2>
    <br>

    <!-- Formulário para adicionar notificação -->
    <form action="../controllers/AdicionarNotificacoes.php" method="POST" style="margin-left: 35px;">
        <h3>Descreva a notificação:</h3>
        <input 
            type="text" 
            name="notificacao" 
            id="observacoes" 
            placeholder="Descreva o procedimento..." 
            maxlength="87" 
            required 
            style="margin-left: 20px;">

        <button type="submit">Cadastrar notificação</button>
    </form>

    <!-- Menu inferior -->
    <div class="container-menu-bar" style="position: relative; margin-top: 530px;">
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
            <div id="funcionarios">
                <img src="../src/assets/images/funcionarios-bar.png" alt="">
            </div>
            <a href="../public/funcionarios.html"><span>Funcionários</span></a>
        </div>
    </div>

</body>
</html>
