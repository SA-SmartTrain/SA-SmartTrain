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
                <a href="./gerenciamento_sensores.php" style=" text-decoration: none;">
                    <h1 id="title">Gerenciamento de Sensores</h1>
                </a>
            </div>
        </div>
    </section>

    <h2>Informações</h2>
    <br>
<form action="../controllers/RemoverSensores.php" method="POST">
    <section class="seletores">
        <h3>Selecione o tipo de sensor:</h3>
        <select id="carga" name="carga" required>
            <option value="">Selecione o tipo...</option>
            <option value="Ultrassonico">Ultrassônico</option>
            <option value="LDR (luminosidade)">LDR (Luminosidade)</option>
            <option value="Sensor DHT11">Sensor DHT11</option>
        </select>

        <h3>Selecione onde o sensor se encontra:</h3>
        <select id="tamanho" name="tamanho" required>
            <option value="">Selecione o trilho...</option>
            <option value="Trilho 1-Sul">Trilho 1 - Sul</option>
            <option value="Trilho 1-Norte">Trilho 1 - Norte</option>
            <option value="Trilho 2-Sul">Trilho 2 - Sul</option>
            <option value="Trilho 2-Norte">Trilho 2 - Norte</option>
            <option value="Trilho 3-Sul">Trilho 3 - Sul</option>
            <option value="Trilho 3-Norte">Trilho 3 - Norte</option>
            <option value="Trilho 4-Sul">Trilho 4 - Sul</option>
            <option value="Trilho 4-Norte">Trilho 4 - Norte</option>
            <option value="Trilho 5-Sul">Trilho 5 - Sul</option>
            <option value="Trilho 5-Norte">Trilho 5 - Norte</option>
            <option value="Trilho 6-Sul">Trilho 6 - Sul</option>
            <option value="Trilho 6-Norte">Trilho 6 - Norte</option>
        </select>

        <h3>Selecione a data da adição:</h3>
        <div class="container">
            <div class="flex">
                <input type="date" name="dataIda" id="dataIda" required>
            </div>
        </div>

        <h3>Descreva o procedimento:</h3>
        <input type="text" name="observacoes" id="observacoes" placeholder="Descreva o procedimento..." maxlength="87" required style="margin-left: 20px;">

        <button type="submit">Remover Sensor</button>
    </section>
</form>


     <div class="container-menu-bar" style="position: relative; margin-top: 90px;">
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
    </div>

</body>

</html>

</html>