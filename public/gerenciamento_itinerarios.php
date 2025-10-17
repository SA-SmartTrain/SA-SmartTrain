<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/gerenciamento_itinerarios.css">
    <title>SmartTrain - Gerenciamento de Itineráios</title>
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
                <a href="./pagina_inicial.html" style=" text-decoration: none;">
                    <h1 id="title">Gerenciamento de Itinerários</h1>
                    <h4>>Linhas Sul > Linhas Norte > Estado Atual</h4>
                </a>
            </div>
        </div>
    </section>

<div class= "todos">
    <select id="velocidade" name="velocidade" form="velocidade_maxima">
        <option value="opcão">Trilho 1-Sul:</option>
    </select>
    <select id="velocidade" name="velocidade" form="velocidade_maxima">
        <option value="opcão">Trilho 2-Sul:</option>
    </select>
    <select id="velocidade" name="velocidade" form="velocidade_maxima">
        <option value="opcão">Trilho 3-Sul:</option>
    </select>

    <select id="velocidade" name="velocidade" form="velocidade_maxima">
        <option value="opcão">Trilho 4-Sul:</option>
    </select>

    <select id="velocidade" name="velocidade" form="velocidade_maxima">
        <option value="opcão">Trilho 5-Sul:</option>
    </select>

    <select id="velocidade" name="velocidade" form="velocidade_maxima">
        <option value="opcão">Trilho 6-Sul:</option>
    </select>
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
            <a href="../public/funcionarios.php"><span>Funcionários</span></a>
        </div>
    </div>
    </div>

    </section>

</body>

</html>