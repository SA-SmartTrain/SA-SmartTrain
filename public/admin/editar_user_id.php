<?php
include_once __DIR__ . '/../../db/conn.php';

session_start();

// Verifica se o ID do usuário foi passado
if (!isset($_GET['id'])) {
    header("Location: visualizar_user.php");
    exit();
}

$id = intval($_GET['id']);

// Busca os dados do usuário
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE idusuarios = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    echo "Usuário não encontrado!";
    exit();
}

// Atualiza os dados do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_usuarios'];
    $email = $_POST['email_usuarios'];
    $cpf = $_POST['cpf_usuarios'];
    $senha = $_POST['senha_usuarios'];
    $perfil = $_POST['perfil'];

    // Validação simples
    if (!in_array($perfil, ['Usuario', 'Gestor', 'Administrador'])) {
        $msg_erro = "Perfil inválido!";
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nome_usuarios = ?, email_usuarios = ?, cpf_usuarios = ?, senha_usuarios = ?, perfil = ? WHERE idusuarios = ?");
        $stmt->bind_param("sssssi", $nome, $email, $cpf, $senha, $perfil, $id);

        if ($stmt->execute()) {
            $msg_sucesso = "Usuário atualizado com sucesso!";
            // Atualiza os dados exibidos
            $usuario['nome_usuarios'] = $nome;
            $usuario['email_usuarios'] = $email;
            $usuario['cpf_usuarios'] = $cpf;
            $usuario['senha_usuarios'] = $senha;
            $usuario['perfil'] = $perfil;
        } else {
            $msg_erro = "Erro ao atualizar usuário: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="/SA-SmartTrain/style/pagina_inicial.css">
</head>

<body>
    <div class="container">
        <div class="container-accessibility-buttons">
            <img src="/SA-SmartTrain/src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
            <img src="/SA-SmartTrain/src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
        </div>
        <h1>Editar Usuário</h1>

        <?php if (isset($msg_sucesso)): ?>
            <div class="msg msg-sucesso"><?php echo $msg_sucesso; ?></div>
        <?php endif; ?>
        <?php if (isset($msg_erro)): ?>
            <div class="msg msg-erro"><?php echo $msg_erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome:</label>
            <input type="text" name="nome_usuarios" value="<?php echo htmlspecialchars($usuario['nome_usuarios']); ?>" required><br><br>

            <label>Email:</label>
            <input type="email" name="email_usuarios" value="<?php echo htmlspecialchars($usuario['email_usuarios']); ?>" required><br><br>

            <label>CPF:</label>
            <input type="text" name="cpf_usuarios" value="<?php echo htmlspecialchars($usuario['cpf_usuarios']); ?>" required><br><br>

            <label>Senha:</label>
            <input type="text" name="senha_usuarios" value="<?php echo htmlspecialchars($usuario['senha_usuarios']); ?>" required><br><br>

            <label>Perfil:</label>
            <select name="perfil" required>
                <option value="Usuario" <?php if ($usuario['perfil'] == 'Usuario') echo 'selected'; ?>>Usuario</option>
                <option value="Gestor" <?php if ($usuario['perfil'] == 'Gestor') echo 'selected'; ?>>Gestor</option>
                <option value="Administrador" <?php if ($usuario['perfil'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
            </select><br><br>

            <button type="submit">Salvar Alterações</button>
            <button type="submit" style="text-decoration: none;"><a href="visualizar_user.php" style="color: white; text-decoration: none;">Voltar</a></button>
        </form>
        
</body>
<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
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

    input[type="text"],
    input[type="email"],
    select {
        width: 70%;
        padding: 10px 12px;
        margin: 6px 0 16px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
        background: #f9f9f9;
        font-size: 16px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 4px #007bff33;
    }

    label {
        font-weight: 500;
        color: #333;
        margin-bottom: 4px;
        display: block;
    }

    button[type="submit"] {
        background-color: rgb(242, 211, 124);
        ;
        color: #fff;
        padding: 10px 22px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.2s;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    form {
        margin-left: 35px;
    }
</style>

</html>