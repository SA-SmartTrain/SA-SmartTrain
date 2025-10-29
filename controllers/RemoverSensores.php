<?php
require_once '../db/conn.php'; // conexão com o banco
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["email"])) {
    header('Location: /SA-SmartTrain/public/gerenciamento_sensores.php');
    exit;
}

// Verifica se a requisição é POST (confirmação da exclusão)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["confirmar_exclusao"])) {
        $id_sensor = trim($_POST["id_sensor"] ?? "");

        // Validar o ID do sensor
        if (!is_numeric($id_sensor) || empty($id_sensor)) {
            echo "<h2>ID de sensor inválido.</h2>";
            exit;
        }

        // Excluir o sensor
        $stmt = $conn->prepare("DELETE FROM sensores WHERE idsensores = ?");
        $stmt->bind_param("i", $id_sensor);

        if ($stmt->execute()) {
            echo "<h2>Sensor excluído com sucesso!</h2>";
            echo '<a href="gerenciamento_sensores.php">Voltar para a página de sensores</a>';
            exit;
        } else {
            echo "<h2>Erro ao excluir sensor: " . htmlspecialchars($stmt->error) . "</h2>";
        }
        $stmt->close();
    }
}

// Se o usuário acessou via GET ou não confirmou, mostrar formulário de confirmação
$id_sensor = $_GET['id'] ?? '';
if (!is_numeric($id_sensor) || empty($id_sensor)) {
    echo "<h2>ID de sensor inválido.</h2>";
    exit;
}
?>

<h2>Tem certeza que deseja excluir este sensor?</h2>
<form method="POST" action="">
    <input type="hidden" name="id_sensor" value="<?php echo htmlspecialchars($id_sensor); ?>">
    <button type="submit" name="confirmar_exclusao" class="btn btn-danger">Confirmar exclusão</button>
    <a href="gerenciamento_sensores.php" class="btn btn-secondary">Cancelar</a>
</form>