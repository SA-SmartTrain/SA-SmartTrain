<?php
include_once __DIR__ . '/../../db/conn.php';

session_start();

// Exclusão de usuário
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE idusuarios = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: visualizar_user.php?msg=excluido");
        exit();
    } else {
        echo "Erro ao excluir usuário: " . $conn->error;
        exit();
    }
}

// Se o formulário de alteração de perfil foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idusuarios'], $_POST['perfil'])) {
    $idusuarios = $_POST['idusuarios'];
    $perfil = $_POST['perfil'];

    // Validação do perfil
    if (!in_array($perfil, ['Usuario', 'Gestor', 'Administrador'])) {
        die("Perfil inválido!");
    }

    // Atualiza o perfil
    $stmt = $conn->prepare("UPDATE usuarios SET perfil = ? WHERE idusuarios = ?");
    $stmt->bind_param("si", $perfil, $idusuarios);

    if ($stmt->execute()) {
        $msg_sucesso = "Perfil atualizado com sucesso!";
    } else {
        $msg_erro = "Erro ao atualizar perfil: " . $conn->error;
    }
}

// Listar usuários
$query = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="shortcut icon" href="/SA-SmartTrain/src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/pagina_inicial.css">
    <title>SmartTrain - Visualizar Usuários</title>
</head>

<body>
    <div class="container-accessibility-buttons">
        <img src="/SA-SmartTrain/src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
        <img src="/SA-SmartTrain/src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
    </div>
    <a href="admin.php" style="text-decoration: none;"><h1>Visualizar Usuários</h1></a>

    <?php if (isset($msg_sucesso)): ?>
        <div class="msg msg-sucesso"><?php echo $msg_sucesso; ?></div>
    <?php endif; ?>

    <?php if (isset($msg_erro)): ?>
        <div class="msg msg-erro"><?php echo $msg_erro; ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Senha</th>
            <th>Perfil</th>
            <th>Opções</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['idusuarios']; ?></td>
                <td><?php echo $row['nome_usuarios']; ?></td>
                <td><?php echo $row['email_usuarios']; ?></td>
                <td><?php echo $row['cpf_usuarios']; ?></td>
                <td><?php echo $row['senha_usuarios']; ?></td>
                <td>
                    <!-- Formulário para alterar perfil -->
                    <form method="POST">
                        <input type="hidden" name="idusuarios" value="<?php echo $row['idusuarios']; ?>">
                        <select name="perfil">
                            <option value="Usuario" <?php if ($row['perfil'] == 'Usuario') echo 'selected'; ?>>Usuario</option>
                            <option value="Gestor" <?php if ($row['perfil'] == 'Gestor') echo 'selected'; ?>>Gestor</option>
                            <option value="Administrador" <?php if ($row['perfil'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
                        </select>
                        <button type="submit">Alterar</button>
                    </form>
                </td>
                <td class="action-buttons">
                    <a href="editar_user_id.php?id=<?php echo $row['idusuarios']; ?>">Editar</a>  |
                    <a href="visualizar_user.php?id=<?php echo $row['idusuarios']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <div class="container-menu-bar">
        <div class="sections-menu-bar" id="press-effect">
            <img src="/SA-SmartTrain/src/assets/images/inicio-bar.png" alt="">
            <div id="incio">
                <a href="../pagina_inicial.php"><span>Início</span></a>
            </div>
        </div>
        <div class="sections-menu-bar" id="press-effect">
            <img src="/SA-SmartTrain/src/assets/images/menu-bar.png" alt="">
            <a href="../documentacoes.html"><span>Menu</span></a>
        </div>
        <div class="sections-menu-bar" id="press-effect">
            <img src="/SA-SmartTrain/src/assets/images/estoque-bar.png" alt="">
            <a href="relatorios_e_analises.html"><span>Estoque</span></a>
        </div>
        <div class="sections-menu-bar" id="press-effect">
            <div id="funcionarios"><img src="/SA-SmartTrain/src/assets/images/funcionarios-bar.png" alt=""></div>
            <a href="/SA-SmartTrain/funcionarios.html"><span>Funcionários</span></a>
        </div>
    </div>
</body>
<style>
    * {
        color: #2C2C2C;
    }

    h1 {
        margin-left: 35px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 26px;
        font-weight: bold;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #F0F0F0;
        padding: 20px;
        overflow-x: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    table,
    th,
    td {
        border: 1px solid #999;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    select {
        padding: 5px;
    }

    button {
        padding: 5px 10px;
        cursor: pointer;
    }

    .action-buttons a {
        margin-right: 10px;
    }

    .msg {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .msg-sucesso {
        background-color: #d4edda;
        color: #155724;
    }

    .msg-erro {
        background-color: #f8d7da;
        color: #721c24;
    }

    .container-menu-bar {
        position: relative;
        display: flex;
        justify-content: center;
        width: 100vw;
        height: 60px;
        gap: 350px;
    }

    .sections-menu-bar {
        position: relative;
        bottom: -40px;
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

    .container-accessibility-buttons {
        display: flex;
        position: relative;
        top: 50px;
        margin-left: 1700px;
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
</style>

</html>