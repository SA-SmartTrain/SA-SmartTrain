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
                <a href="./hub_de_gerenciamentos.php" style=" text-decoration: none;">
                    <h1 id="title">Cadastro de Cargas</h1>
                </a>
            </div>
        </div>
    </section>

    <h2>Selecione uma opção:</h2>
    <br>

    <div class="container-opcoes">
        <div class="opcoes" style=" margin-left: 40px;">

            <a href="./adicionar_cargas.php" style=" text-decoration: none;">
                <img src="../src/assets/images/adicionar.png" style=" width: 30px; height: 30px;  margin-bottom: -47px;">
                <div class="opcao">
                    <h3 id="opc">Adicionar Carga</h3>
                </div>
            </a>

        </div>

         <div class="opcoes" style=" margin-left: 40px;">

            <a href="./excluir_cargas.php" style=" text-decoration: none;">
                <img src="../src/assets/images/remover.png" style=" width: 30px; height: 30px;  margin-bottom: -47px;">
                <div class="opcao">
                    <h3 id="opc">Remover Carga</h3>
                </div>
            </a>

        </div>

        <div class="container-menu-bar" style="position: relative; bottom: -150px;">
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

<style>
    @media screen and (max-width: 960px) {


  .container-menu-bar {
    position: relative;
    top: 440px;
    gap: 40px;
    right: -20px;
  }


}
</style>