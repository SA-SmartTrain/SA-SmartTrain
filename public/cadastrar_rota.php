<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/cadastrar_rotas.css">
    <title>SmartTrain - Cadastro de Rota</title>
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
                <a href="../pagina_inicial" style=" text-decoration: none;">
                    <h1 id="title">Cadastro de Rotas</h1>
                </a>
            </div>
        </div>
    </section>

    <div class="containerh2">
        <h2>Informações</h2>
    </div>

    <br>
    <form action="../controllers/CadastrarSensores.php" method="POST">
        <section class="seletores">
            <h3>Selecione o destino:</h3>
            <select id="carga" name="carga" required>
                <option value="">Selecione o destino...</option>
                <option value="joinville">Joinville</option>
                <option value="araquari">Araquari</option>
                <option value="sfs">São Franscisco do Sul</option>
            </select>


            <h3>Selecione o ponto de partida:</h3>
            <select id="tamanho" name="tamanho" required>
                <option value="">Selecione o ponto de partida...</option>
                <option value="joinville">Joinville</option>
                <option value="araquari">Araquari</option>
                <option value="sfs">São Franscisco do Sul</option>
            </select>
            <div class="containerdata">
                <h3>Selecione a data:</h3>
                <div class="flex">
                    <input type="date" name="dataIda" id="dataIda" required>
                </div>
            </div>
            <div class="containerproce">
                <h3>Descreva o procedimento:</h3>
                <input type="text" name="observacoes" id="observacoes" placeholder="Descreva o procedimento...">
            </div>
        </section>
        <button type="submit">Adicionar Rota</button>
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
            <a href="../public/funcionarios.php"><span>Funcionários</span></a>
        </div>
    </div>
    </div>

</body>

</html>

</html>