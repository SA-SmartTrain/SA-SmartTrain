<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/adicionar_cargas.css">
    <title>SmartTrain - Cadastro de Cargas</title>
</head>

<body>
    <section>
        <div class="container">
            <div class="container-accessibility-buttons">
                <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
            </div>
        </div>
    </section> 

    <div class="containerdois flex">
            <div>
                <a href="./pagina_inicial.html" style=" text-decoration: none;">
                    <h1 id="title">Cadastro de Cargas</h1>
                </a>
            </div>
        </div>
<br>
    <div class="containertres">
        <form action="../controllers/CadastrarCargas.php" method="POST">
            <label>Tipo de Carga:</label>
            <select name="tipocarga" required>
                <option value="">Selecione o tipo...</option>
                <option value="Soja">Soja</option>
                <option value="Milho">Milho</option>
                <option value="Feijão">Feijão</option>
                <option value="Ervilha">Ervilha</option>
                <option value="Carvão">Carvão</option>
                <option value="Açucar">Açucar</option>
                <option value="Barras de Aço">Barras de Aço</option>
                <option value="Minério">Minério</option>
                <option value="Cereais">Cereais</option>
                <option value="Petróleo">Petróleo</option>
            </select>
        </form>
    </div>

    <br><br>

    <div class="containerquatro">
        <label>Tamanho da Carga:</label>
        <select name="tamanhocarga" required>
            <option value="">Selecione o tamanho...</option>
            <option value="1-50 Toneladas">1-50 Toneladas</option>
            <option value="50-100 Toneladas">50-100 Toneladas</option>
            <option value="100-500 Toneladas">100-500 Toneladas</option>
            <option value="500-1.000 Toneladas">500-1.000 Toneladas</option>
            <option value="1.000-5.000 Toneladas">1.000-5.000 Toneladas</option>
            <option value="5.000-10.000 Toneladas">5.000-10.000 Toneladas</option>
            <option value="10.000-15.000 Toneladas">10.000-15.000 Toneladas</option>
            <option value="Mais de 20 mil Toneladas">Mais de 20 mil Toneladas</option>
            <option value="Mais de 50 mil Toneladas">Mais de 50 mil Toneladas</option>
            <option value="Mais de 100 mil Toneladas">Mais de 100 mil Toneladas</option>
            <option value="Mais de 500 mil Toneladas">Mais de 500 mil Toneladas</option>
        </select>
    </div>

    <br><br>

    <div class="containercinco">
        <label>Ponto de Partida:</label>
        <select name="pontopartida" required>
            <option value="">Selecione a partida...</option>
            <option value="Mafra">Mafra</option>
            <option value="São Francisco do Sul">São Francisco do Sul</option>
            <option value="Guaramirim">Guaramirim</option>
            <option value="Joinville">Joinville</option>
            <option value="Araquari">Araquari</option>
            <option value="Itapoá">Itapoá</option>
            <option value="Navegantes">Navegantes</option>
            <option value="Rio do Sul">Rio do Sul</option>
            <option value="Tubarão">Tubarão</option>
            <option value="Curitiba">Curitiba</option>
        </select>
    </div>

    <br><br>
    <div class="containerseis">
        <label>Ponto de Destino:</label>
        <select name="pontodestino" required>
            <option value="">Selecione o destino...</option>
            <option value="Mafra">Mafra</option>
            <option value="São Francisco do Sul">São Francisco do Sul</option>
            <option value="Guaramirim">Guaramirim</option>
            <option value="Joinville">Joinville</option>
            <option value="Araquari">Araquari</option>
            <option value="Itapoá">Itapoá</option>
            <option value="Navegantes">Navegantes</option>
            <option value="Rio do Sul">Rio do Sul</option>
            <option value="Tubarão">Tubarão</option>
            <option value="Curitiba">Curitiba</option>
        </select>
    </div>
    <br><br>
    <div class="containersete">
        <label>Data de Envio:</label>
        <input type="date" name="envio_cargas" required>
    </div>

    <br><br>

    <div class="containeroito">
        <label>Data de Chegada:</label>
        <input type="date" name="chegada_cargas" required>
    </div>

    <br><br>

    <div class="containernove">
        <input type="submit" value="Cadastrar">
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