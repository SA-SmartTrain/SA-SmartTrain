<?php
require_once(__DIR__ . '/../db/conn.php');

session_start();

// Verifica se o usuário já está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../login/cadastro-se-dados.php');
    exit;
}

// Pega o email da sessão (email antigo, usado no WHERE)
$email = $_SESSION["email_usuarios"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome     = trim($_POST["nome_usuarios"] ?? "");
    $novo_email    = trim($_POST["email_usuarios"] ?? "");
    $novo_telefone = trim($_POST["telefone_usuario"] ?? "");
    $novo_endereco = trim($_POST["endereco_usuario"] ?? "");

    $foto_nome = null;
    if (isset($_FILES['foto_usuarios']) && $_FILES['foto_usuarios']['error'] === UPLOAD_ERR_OK) {
        $pasta_destino = __DIR__ . '/uploads/'; // Crie esta pasta se não existir
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0755, true);
        }

        $extensao = pathinfo($_FILES['foto_usuarios']['name'], PATHINFO_EXTENSION);
        $foto_nome = uniqid('perfil_', true) . '.' . $extensao;
        $caminho_completo = $pasta_destino . $foto_nome;

        if (!move_uploaded_file($_FILES['foto_usuarios']['tmp_name'], $caminho_completo)) {
            die("Erro ao fazer upload da imagem.");
        }
    }

    // Atualiza os dados no banco
    if ($foto_nome) {
        $stmt = $conn->prepare("UPDATE usuarios 
                                SET nome_usuarios = ?, email_usuarios = ?, telefone_usuario = ?, endereco_usuario = ?, foto_usuarios = ? 
                                WHERE email_usuarios = ?");
        $stmt->bind_param("ssssss", $novo_nome, $novo_email, $novo_telefone, $novo_endereco, $foto_nome, $email);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios 
                                SET nome_usuarios = ?, email_usuarios = ?, telefone_usuario = ?, endereco_usuario = ? 
                                WHERE email_usuarios = ?");
        $stmt->bind_param("sssss", $novo_nome, $novo_email, $novo_telefone, $novo_endereco, $email);
    }

    if (!$stmt) {
        die("Erro na preparação da consulta de atualização: " . $conn->error);
    }

    if ($stmt->execute()) {
        $_SESSION["email_usuarios"] = $novo_email;
        header('Location: meu_perfil_beta.php');
        exit;
    } else {
        echo "Erro ao atualizar os dados: " . $stmt->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
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
                <input type="submit" value="Editar">
            </div>
    </div>
    </div>

    </form>
    </section>
</body>

<style>
* {
    color: #2C2C2C;
    background-color: #F0F0F0;
    font-family: Arial, Helvetica, sans-serif;
}

body {
    overflow-x: hidden;
}

h1 {
    position: relative;
    margin-left: 35px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 26px;
    font-weight: bold;
}

.container {
    display: flex;
    max-width: 500px;
    margin: 0 auto;
    border-radius: 10px;
}

.flex {
    gap: 30px;
    display: flex;
}


.container_dados {
    width: 100px;
    height: 15px;
    margin: 0 auto;
    background-color: #f0f0f0;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    font-weight: bold;
    border-radius: 10px;
    text-align: center;
}



#date {
    border: none;
    align-items: center;
    background-color: #F0F0F0;
}


.seletores {
    max-width: 500px;
    width: 100%;
    margin-left: 35px;
    margin-top: 45px;
    position: relative;
    bottom: 50px;
}

img {
    max-width: 50px;
    max-height: 50px;
}

h3 {
    font-weight: 500;
}

#carga {
    border-radius: 10px;
    width: 400px;
    height: 50px;
}

#tamanho {
    border-radius: 10px;
    width: 400px;
    height: 50px;
}

#partida {
    border-radius: 10px;
    width: 400px;
    height: 50px;
}

#destino {
    border-radius: 10px;
    width: 400px;
    height: 50px;
}

/**/

.container-menu-bar {
    position: relative;
    margin-top: 13%;
    display: flex;
    right: 35px;
    justify-content: center;
    width: 100vw;
    height: 60px;
    gap: 350px;
}

.sections-menu-bar {
    position: relative;
    left: 6px;
    width: 50px;
    height: 50px;
    margin-left: 10px;
    opacity: 0.3;
}

.sections-menu-bar span {
    position: relative;
    left: 5px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    font-weight: 600;
}

.sections-menu-bar a {
    text-decoration: none;
    color: black;
}

.container-menu-bar img {
    width: 100%;
}

#funcionarios {
    position: relative;
    left: 20px;
}

#press-effect:hover {
    opacity: 1;
}

#notifications:hover {
    cursor: pointer;
}

.container-accessibility-buttons {
    display: flex;
    position: relative;
    top: 55px;
    margin-left: 1000px;
    width: 100px;
    height: 30px;
    gap: 1px;
    z-index: 1;
}

.container-accessibility-buttons img {
    margin-left: 30px;
    width: 30px;
    height: 30px;
}

input {
    top: 50px;
    right: 1px;
    position: relative;
}

#dataTeste {
    top: 3px;
    right:10px;
    position: relative;
}

#carga {
    background-color: rgb(242, 211, 124);
}

#tamanho {
    background-color: rgb(242, 211, 124);
}

#destino {
    background-color: rgb(242, 211, 124);
}

#partida {
    background-color: rgb(242, 211, 124);
}

#dia {
    border-right: 500px;
}

#date {
    border: none;
}

@media screen and (max-width: 480px) {

    h1 {
        position: relative;
        left: -20px;
        font-size: 22px;
    }

    #title {
        position: relative;
        top: -20px;
    }

    .container-accessibility-buttons {
        position: relative;
        right: 670px;
        top: 25px;
        gap: 16px;
    }

    .container-accessibility-buttons img {
        margin-left: 0;
        width: 26px;
        height: 26px;
    }

    h3 {
        position: relative;
        right: 20px;
        font-size: 18px;
    }

    select {
        position: relative;
        right: 20px;
        max-width: 300px;
    }

        .container-menu-bar {
        position: fixed;
        left: -30px;
        top: 715px;
        gap: 40px;
        z-index: 999;

    }

    .container-menu-bar img {
        left: 5px;
        width: 46px;
        height: 46px;
    }

    input {
    top: 13px;
    right: 0px;
    position: relative;
}
}

</style>