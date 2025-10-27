<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/gerenciamento_trens.css">
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
        <div class="containerdois flex">
            <div>
                    <h1 id="title">Gerenciamento de Trens</h1>
                    <h2>Informações:</h2>
            </div>
        </div>
    </section>

    <section class="seletores">
        <form action="gerenciar_trens.php" method="POST">

            <!-- <label for="identificador">Identificador (ID) do Trem: </label>
            <input type="text" name="Identificador" id="identificador"> -->

            <h3>Informe a carga que o trem transportará:</h3>
            <select id="carga" name="carga_trem">
                <option value="opcão">Selecione a carga...</option>

                <?php
                    require_once('../db/conn.php');
                    $resultado = $conn->query("SELECT * FROM cargas;");
                    if($resultado->num_rows >= 1) {
                        while($row=$resultado->fetch_assoc()) {
                            var_dump($row);
                            echo "<option value='".$row["tipo_carga"]."'>".$row["tipo_carga"]." de ".$row["partida_carga"]." para ".$row["destino_carga"]." </option>";
                        }
                    }
                ?>
                <!-- <option value="soja">Soja</option>
                <option value="milho">Milho</option>
                <option value="feijão">Feijão</option>
                <option value="ervilha">Ervilha</option>
                <option value="carvão">Carvão</option>
                <option value="açucar">Açucar</option>
                <option value="Barras de Aço">Barras de Aço</option>
                <option value="minério">Minério</option>
                <option value="cereais">Cereais</option>
                <option value="petróleo">Petróleo</option> -->
            </select>


            <h3>Informe a capacidade máxima do trem:</h3>
            <select id="tamanho" name="capacidade_trem">
                <option value="opcão">Selecione o tamanho...</option>
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

            <h3>Informe a quantidade de vagões:</h3>
            <select id="partida" name="vagoes_trem">
                <option value="opcão">Selecione a quantidade...</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
                <option value="60">60</option>
            </select>

            <h3>Informe o estado atual:</h3>
            <select id="destino" name="estado_trem">
                <option value="opcão">Selecione o estado...</option>
                <option value="Parado">Parado</option>
                <option value="Em rota">Em rota</option>
                <option value="Em manutenção">Em manutenção</option>
                <option value="Em carregamento">Em carregamento</option>
                <option value="Aguardando carga">Aguardando carga</option>
                <option value="Chegou ao destino">Chegou ao destino</option>
            </select>

            <h3>Informe a velocidade máxima:</h3>
            <select id="velocidade" name="velocidade_trem">
                <option value="opcão">Selecione a velocidade...</option>
                <option value="60km/h">60km/h</option>
                <option value="80km/h">80km/h</option>
                <option value="100km/h">100km/h</option>
                <option value="120km/h">120km/h</option>
            </select>
            <input type="submit"/>
        </form>
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