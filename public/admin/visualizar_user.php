<?php
// Incluir o arquivo de conexão
include_once('../bd/conexao.php');

$ini_array = parse_ini_file('../../bd/config.ini', true); // Ajuste o caminho
$dbHost = $ini_array['database']['host'];
$dbUser = 'smarttrain';
$dbPass = $ini_array['database']['password'];
$dbName = 'smarttrain';
$dbPort = 6306;

$conexao = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

// Listar usuários
$query = "SELECT * FROM cadastro_usuario";
$result = mysqli_query($conexao, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/src/assets/logo/favicon.ico" type="image/x-icon">
    <title>SmartTrain - visualizar_user</title>
</head>

<body>
    <main>
        <section>
            <div class="container">
                <div class="header">
                    <h1>visualizar_user - SmartTrain</h1>
                </div>
                <div>
                    <form action="/bd/conexao.php" method="POST">
                        <section id="listar_usuarios">
                            <div class="tabela">
                                <table border="1">
                                    <tr>
                                        <th id="table-id">Id</th>
                                        <th id="table-nome">Usuario</th>
                                        <th>Email</th>
                                        <th>CPF</th>
                                        <th id="table-nome">Senha</th>
                                        <th>Opções</th>
                                    </tr>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <!--Tirar do BD e manipular e devolver para a web-->
                                        <tr>
                                            <td>
                                                <?php echo $row['id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['usuario']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['email']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['cpf']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['senha']; ?>
                                            </td>
                                            <td><a href="">Editar | Excluir</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </table>
                            </div>
                        </section>
                </div>
                <div class="container-menu-bar">
                    <div class="sections-menu-bar" id="press-effect">
                        <img src="/src/assets/images/inicio-bar.png" alt="">
                        <div id="incio">
                            <a href="/public/pagina_inicial.html"><span>Inicío</span></a>
                        </div>
                    </div>
                    <div class="sections-menu-bar" id="press-effect">
                        <img src="/src/assets/images/menu-bar.png" alt="">
                        <a href="../public/documentacoes.html"><span>Menu</span></a>
                    </div>
                    <div class="sections-menu-bar" id="press-effect">
                        <img src="/src/assets/images/estoque-bar.png" alt="">
                        <a href="#"><span>Estoque</span></a>
                    </div>
                    <div class="sections-menu-bar" id="press-effect">
                        <div id="funcionarios"><img src="/src/assets/images/funcionarios-bar.png" alt=""></div>
                        <a href="../public/funcionarios.html"><span>Funcionários</span></a>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
</body>
<style>
    body {
        background-color: #F0F0F0;
        overflow-x: hidden;
    }

    .container-menu-bar {
        position: relative;
        margin-top: 28%;
        display: flex;
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
</style>

</html>