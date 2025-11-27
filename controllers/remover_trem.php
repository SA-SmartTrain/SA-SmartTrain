<?php
require_once __DIR__ . '/../db/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "Não encontrado.";
        exit;
    }
    $id = (int) $_GET['id'];

    $stmt = $mysqli->prepare("SELECT idtrens, identificador_trem, carga_trem, estado_trem FROM trens WHERE idtrens = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $trem = $res->fetch_assoc();
    $stmt->close();

    if (!$trem) {
        echo "Trem não encontrado.";
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Confirmar exclusão</title>
        <link rel="stylesheet" href="../src/assets/css/bootstrap.min.css"> 
    </head>
    <body class="p-4">
        <div class="container">
            <h4>Confirmar exclusão</h4>
            <p>Deseja realmente excluir o trem #<?php echo htmlspecialchars($trem['idtrens']); ?> —
               <?php echo htmlspecialchars($trem['identificador_trem']); ?> (<?php echo htmlspecialchars($trem['carga_trem']); ?>)?</p>

            <form method="post" action="" class="d-inline">
                <input type="hidden" name="idtrens" value="<?php echo htmlspecialchars($trem['idtrens']); ?>">
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
            <a href="../public/gerenciamento_trens.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idtrens'] ?? null;
    if (!$id || !is_numeric($id)) {
        echo "ID inválido.";
        exit;
    }
    $id = (int) $id;

    $stmt = $mysqli->prepare("DELETE FROM trens WHERE idtrens = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ../public/gerenciamento_trens.php');
        exit;
    } else {
        echo "Erro ao excluir o trem: " . $stmt->error;
    }

    $stmt->close();
}
?>