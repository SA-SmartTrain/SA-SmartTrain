<?php
require_once __DIR__ . '/../db/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "Não encontrado.";
        exit;
    }
    $id = (int)$_GET['id'];
    $stmt = $mysqli->prepare("SELECT idtrens, identificador_trem, carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem FROM trens WHERE idtrens = ?");
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
    <html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Trem</title>
        <link rel="stylesheet" href="../src/assets/css/bootstrap.min.css">
        <style>
            body { padding: 20px; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input, textarea, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
            button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background-color: #0056b3; }
            .btn-secondary { display: inline-block; padding: 10px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; margin-left: 8px; }
            .btn-secondary:hover { background-color: #545b62; }
        </style>
    </head>
    <body>
        <div class="container" style="max-width: 600px;">
            <h2>Editar Trem #<?php echo htmlspecialchars($trem['idtrens']); ?></h2>
            <form method="post" action="../controllers/editar_trem.php">
                <input type="hidden" name="idtrens" value="<?php echo htmlspecialchars($trem['idtrens']); ?>">
                
                <div class="form-group">
                    <label>Identificador:</label>
                    <input type="text" name="identificador_trem" value="<?php echo htmlspecialchars($trem['identificador_trem'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label>Carga:</label>
                    <select name="carga_trem" required>
                        <option value="<?php echo htmlspecialchars($trem['carga_trem']); ?>" selected><?php echo htmlspecialchars($trem['carga_trem']); ?></option>
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
                </div>

                <div class="form-group">
                    <label>Capacidade:</label>
                    <select name="capacidade_trem" required>
                        <option value="<?php echo htmlspecialchars($trem['capacidade_trem']); ?>" selected><?php echo htmlspecialchars($trem['capacidade_trem']); ?></option>
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

                <div class="form-group">
                    <label>Vagões:</label>
                    <select name="vagoes_trem" required>
                        <option value="<?php echo htmlspecialchars($trem['vagoes_trem']); ?>" selected><?php echo htmlspecialchars($trem['vagoes_trem']); ?></option>
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
                </div>

                <div class="form-group">
                    <label>Estado:</label>
                    <select name="estado_trem" required>
                        <option value="<?php echo htmlspecialchars($trem['estado_trem']); ?>" selected><?php echo htmlspecialchars($trem['estado_trem']); ?></option>
                        <option value="Parado">Parado</option>
                        <option value="Em rota">Em rota</option>
                        <option value="Em manutenção">Em manutenção</option>
                        <option value="Em carregamento">Em carregamento</option>
                        <option value="Aguardando carga">Aguardando carga</option>
                        <option value="Chegou ao destino">Chegou ao destino</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Velocidade:</label>
                    <select name="velocidade_trem" required>
                        <option value="<?php echo htmlspecialchars($trem['velocidade_trem']); ?>" selected><?php echo htmlspecialchars($trem['velocidade_trem']); ?></option>
                        <option value="60km/h">60km/h</option>
                        <option value="80km/h">80km/h</option>
                        <option value="100km/h">100km/h</option>
                        <option value="120km/h">120km/h</option>
                    </select>
                </div>

                <button type="submit">Salvar</button>
                <a href="../public/gerenciamento_trens.php" class="btn-secondary">Cancelar</a>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['idtrens'] ?? 0);
    $identificador = $_POST['identificador_trem'] ?? '';
    $carga = $_POST['carga_trem'] ?? '';
    $capacidade = $_POST['capacidade_trem'] ?? '';
    $vagoes = $_POST['vagoes_trem'] ?? '';
    $estado = $_POST['estado_trem'] ?? '';
    $velocidade = $_POST['velocidade_trem'] ?? '';

    if ($id <= 0) {
        echo "ID inválido.";
        exit;
    }

    $stmt = $mysqli->prepare("UPDATE trens SET identificador_trem = ?, carga_trem = ?, capacidade_trem = ?, vagoes_trem = ?, estado_trem = ?, velocidade_trem = ? WHERE idtrens = ?");
    if (!$stmt) {
        echo "Erro ao preparar query: " . $mysqli->error;
        exit;
    }
    $stmt->bind_param('ssssssi', $identificador, $carga, $capacidade, $vagoes, $estado, $velocidade, $id);
    if ($stmt->execute()) {
        $stmt->close();
        header('Location: ../public/gerenciamento_trens.php'); 
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
    $stmt->close();
}
?>