<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/monitoramento_cargas.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <title>SmartTrain - Monitoramento de cargas</title>
</head>

<body>
    <main>
        <section>
            <div class="container">
                <div class="container-accessibility-buttons">
                    <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                    <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
                </div>
                <a href="./pagina_inicial.html" style=" text-decoration: none;">
                    <h1 id="title">Monitoramento de Cargas</h1>
                </a>
                <div class="api-maps" id="map"></div>
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
                        <a href="../public/relatorios_e_analises.php"><span>Estoque</span></a>
                    </div>
                    <div class="sections-menu-bar" id="press-effect">
                        <div id="funcionarios"><img src="../src/assets/images/funcionarios-bar.png" alt=""></div>
                        <a href="../public/funcionarios.html"><span>Funcionários</span></a>
                    </div>
                </div>
            </div>
        </section>

        <div class="botoes-container"
            style="position: absolute; top: 700px; right: 60px; z-index: 1000; display: flex; gap: 20px;">
            <a href="#" onclick="openAddStationModal()" style="text-decoration: none;">
                <div class="adicionar-alerta"
                    style="width: 170px; display: flex; align-items: center; background: #222; border-radius: 8px; padding: 6px 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <img src="../src/assets/images/adicionar.png" alt=""
                        style="width: 20px; height: 20px; margin-right: 6px;">
                    <span
                        style="color: rgb(242, 211, 124); font-size: 14px; font-family: Arial, Helvetica, sans-serif;">Nova
                        Estação</span>
                </div>
            </a>

            <a href="#" style="text-decoration: none;">
                <div class="adicionar-alerta"
                    style="width: 170px; display: flex; align-items: center; background: #222; border-radius: 8px; padding: 6px 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <img src="../src/assets/images/rotas.png" alt=""
                        style="width: 20px; height: 20px; margin-right: 6px;">
                    <span
                        style="color: rgb(242, 211, 124); font-size: 14px; font-family: Arial, Helvetica, sans-serif;">Nova
                        Rota</span>
                </div>
            </a>
        </div>

        <div class="botoes-container"
            style="position: absolute; top: 740px; right: 60px; z-index: 1000; display: flex; gap: 20px;">
            <a href="cadastrar_rota.php" style="text-decoration: none;">
                <div class="adicionar-alerta"
                    style="width: 170px; display: flex; align-items: center; background: #222; border-radius: 8px; padding: 6px 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <img src="../src/assets/images/edit.png" alt=""
                        style="width: 20px; height: 20px; margin-right: 6px;">
                    <span
                        style="color: rgb(242, 211, 124); font-size: 14px; font-family: Arial, Helvetica, sans-serif;">Editar</span>
                </div>
            </a>

            <a href="#" style="text-decoration: none;">
                <div class="adicionar-alerta"
                    style="width: 170px; display: flex; align-items: center; background: #222; border-radius: 8px; padding: 6px 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                    <img src="../src/assets/images/save.png" alt=""
                        style="width: 20px; height: 20px; margin-right: 6px;">
                    <span
                        style="color: rgb(242, 211, 124); font-size: 14px; font-family: Arial, Helvetica, sans-serif;">Salvar</span>
                </div>
            </a>
        </div>

        <!---->
        <div class="header-leftnavbar"
            style="position: absolute; top: 85px; left: 0; width: 15%; height: 74%; background: #222; border-radius: 0 16px 16px 0; box-shadow: 2px 0 12px rgba(0,0,0,0.08); z-index: 900; display: flex; flex-direction: column; padding: 24px 18px;">
            <div style="margin-bottom: 24px;">
                <h2
                    style="color:rgb(242, 211, 124);; font-size: 20px; font-family: Arial, Helvetica, sans-serif; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-location-dot" style="color: rgb(242, 211, 124);"></i> Estações
                </h2>
                <hr style="border-color: rgb(242, 211, 124);;">
                <div id="estacoes-list" <div class="textos"
                    style="color: rgb(242, 211, 124); font-size: 15px; font-family: Arial, Helvetica, sans-serif; min-height: 60px; display: flex; align-items: center;">
                    <p style="margin: 0; color: rgb(242, 211, 124);; text-align: left;"><?php ?></p>
                </div>

                <h2
                    style="color: rgb(242, 211, 124);; font-size: 20px; font-family: Arial, Helvetica, sans-serif; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-train" style="color: rgb(242, 211, 124);;"></i> Rotas
                </h2>
                <hr style="border-color: rgb(242, 211, 124);;">
                <div id="estacoes-list" <div class="textos"
                    style="color: rgb(242, 211, 124);; font-size: 15px; font-family: Arial, Helvetica, sans-serif; min-height: 60px; display: flex; align-items: center;">
                    <p style="margin: 0; color: rgb(242, 211, 124);; text-align: left;"><?php ?></p>
                </div>
            </div>
        </div>
        <div>

        </div>
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        </div>
    </main>
    
    <!-- Código do Popup -->
    <div id="add-station-modal" style="font-family: Arial; display: none; position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; border-radius: 10px; position: relative;">
            <span onclick="closeAddStationModal()" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <h2 style="text-align: center; margin-bottom: 20px;">Adicionar Estação</h2>
            <form action="processar_adicionar_estacao.php" method="POST">
                <label for="station_name" style="display: block; margin-bottom: 5px;">Nome da Estação:</label>
                <input type="text" id="station_name" name="station_name" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">

                <label for="address" style="display: block; margin-bottom: 5px;">Endereço:</label>
                <input type="text" id="address" name="address" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;">

                <label for="latitude" style="display: block; margin-bottom: 5px;">Latitude:</label>
                <input type="text" id="latitude" name="latitude" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;" placeholder="-14.225000">

                <label for="longitude" style="display: block; margin-bottom: 5px;">Longitude:</label>
                <input type="text" id="longitude" name="longitude" required style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;" placeholder="-51.925500">

                <button type="submit" style="background-color: rgb(242, 211, 124); color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px;">Salvar Estação</button>
            </form>
        </div>
    </div>

    
    
    <script>
        function openAddStationModal() {
            document.getElementById('add-station-modal').style.display = 'block';
        }

        function closeAddStationModal() {
            document.getElementById('add-station-modal').style.display = 'none';
        }

        // Fecha o modal se o usuário clicar fora dele
        window.onclick = function(event) {
            const modal = document.getElementById('add-station-modal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    
</body>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="">
</script>
<script src="https://unpkg.com/osmtogeojson@3.0.0/osmtogeojson.js"></script>
<script src="../src/api_maps.js"></script>

</html>