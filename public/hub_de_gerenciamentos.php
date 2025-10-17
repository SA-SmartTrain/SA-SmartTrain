<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/SA-SmartTrain/src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/dashboard.css">
    <link rel="stylesheet" href="../style/dashboard_calendar.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet' />
    <title>SmartTrain - Hub de Gerenciamento</title>
</head>

<body>
    <main>
        <section>
            <div class="container">
                <div class="container-accessibility-buttons">
                    <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                    <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
                </div>
                <a href="./pagina_inicial.php" style=" text-decoration: none;">
                    <h1 id="title">Hub de Gerenciamento</h1>
                </a>
                <a href="#linkar-page">
                    <div class="sections-double-left">
                        <p>Gerenciamento de Sensores</p>
                        <div class="section-double-left-img">
                            <a href="../public/gerenciamento_sensores.php"> <img
                                    src="../src/assets/images/sensores.png" alt=""></a>
                        </div>
                </a>
            </div>
            <div class="sections-double-right">
                <p>Gerenciamento de Cargas</p>
                <div class="section-double-right-img">
                    <a href="../public/cadastro_de_cargas.php"><img src="../src/assets/images/cargas.png"
                            alt=""></a>
                </div>

                <div class="container-baixo" style="position: relative; bottom: 50px; right: 390px;">
                    </a>
                    <a href="#linkar-page">
                        <div class="sections-double-left">
                            <p>Gerar Relatório</p>
                            <div class="section-double-left-img">
                                <a href="../public/gerar_relatorio.html"> <img
                                        src="../src/assets/images/relatorio.png" alt=""></a>
                            </div>
                    </a>
                </div>
                <div class="sections-double-right">
                    <p>Gerenciamento de Trens</p>
                    <div class="section-double-right-img">
                        <a href="../public/gerenciamento_geral_trens.php"><img src="../src/assets/images/trem.png"
                                alt=""></a>
                    </div>
                </div>
            </div>
            </div>
            <div class="container-menu-bar" style="position: relative; bottom: -125px;">
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
        </section>
    </main>
    <script src="../src/api_clima_dashboard.js"></script>
    <script src="../src/api_clima_dashboard.js"></script>
    <script src="../src/calendar.js"></script>
</body>
<style>
@media screen and (max-width: 480px) {

    .container-baixo {
        position: relative;
        left: -199px;
    }

  .container-menu-bar {
    position: relative;
    top: 77px;
    gap: 45px;
    right: 30px;
  }

  .container-menu-bar img {
    left: 5px;
    width: 46px;
    height: 46px;
  }
}
</style>

</html>