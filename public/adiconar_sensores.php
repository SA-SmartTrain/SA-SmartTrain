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
    <section class="seletores">
        <h3>Selecione o tipo de sensor:</h3>
        <select id="carga" name="tipocarga" form="tipo_carga">
            <option value="opcão">Selecione o tipo...</option>
            <option value="Sensor Ultrassônico">Ultrassônico</option>
            <option value="LDR">LDR (Luminosidade)</option>
            <option value="DHt11">Sensor DHT11</option>
        </select>

        <h3>Selecione onde o sensor se encontra:</h3>
        <select id="tamanho" name="tamanhocarga" form="tamanho_carga">
            <option value="opcão">Selecione o trilho...</option>
            <option value="trilho1">Trilho 1- Sul</option>
            <option value="trilho1">Trilho 1- Norte</option>
            <option value="trilho2">Trilho 2- Sul</option>
            <option value="trilho2">Trilho 2- Norte</option>
            <option value="trilho3">Trilho 3- Sul</option>
            <option value="trilho3">Trilho 3- Norte</option>
            <option value="trilho4">Trilho 4- Sul</option>
            <option value="trilho4">Trilho 4- Norte</option>
            <option value="trilho5">Trilho 5- Sul</option>
            <option value="trilho5">Trilho 5- Norte</option>
            <option value="trilho6">Trilho 6- Sul</option>
            <option value="trilho6">Trilho 6- Norte</option>
        </select>


        <h3>Selecione a data da adição:</h3>
        <form>
            <div class="container">
                <div class="flex">
                    <div class="container_dados">
                        <input type="date" name="date" id="dataTeste">
                    </div>
                </div>
            </div>
        </form>

        <h3>Selecione a data da remoção:</h3>
        <form>
            <div class="container">
                <div class="flex">
                    <div class="container_dados">
                        <input type="date" name="date" id="dataTeste">
                    </div>
                </div>
            </div>
            <h3>Descreva o procedimento:</h3>
            <input type="text" name="Observacoes">

        </form>
        <br><br>

        <input type="button" value="Enviar" id="eee">

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
                <a href="../public/funcionarios.html"><span>Funcionários</span></a>
            </div>
        </div>
        </div>

    </section>

</body>

</html>

</html>