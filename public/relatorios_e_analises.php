<?php
require_once __DIR__ . '/../db/conn.php';

$success = '';
$error = '';

if (!isset($mysqli) || !$mysqli) {
    $error = 'Conexão com o banco não encontrada. Verifique db/conn.php';
} else {
    $table = 'relatorios';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids'])) {
        $sql = "UPDATE {$table} SET carga_relatorio = ?, data_relatorio = NULLIF(?,''), quantidade_relatorio = ? WHERE idrelatorios = ?";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            $error = 'Erro ao preparar statement: ' . $mysqli->error;
        } else {
            foreach ($_POST['ids'] as $id) {
                $id = (int)$id;
                $carga = isset($_POST['carga'][$id]) ? trim($_POST['carga'][$id]) : '';
                $data = isset($_POST['data'][$id]) && $_POST['data'][$id] !== '' ? $_POST['data'][$id] : '';
                $quantidade = isset($_POST['quantidade'][$id]) ? (int)$_POST['quantidade'][$id] : 0;

                $stmt->bind_param('ssii', $carga, $data, $quantidade, $id);
                if (!$stmt->execute()) {
                    $error = 'Erro ao atualizar ID ' . $id . ': ' . $stmt->error;
                    break;
                }
            }
            if ($error === '') $success = 'Alterações salvas com sucesso.';
            $stmt->close();
        }
    }

    $result = $mysqli->query("SELECT idrelatorios, carga_relatorio, data_relatorio, quantidade_relatorio FROM relatorios ORDER BY idrelatorios ASC");
    $rows = [];
    if ($result) {
        while ($r = $result->fetch_assoc()) $rows[] = $r;
        $result->free();
    } else {
        if ($error === '') $error = 'Erro ao carregar registros: ' . $mysqli->error;
    }
}
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
                        <div class="container_amarelo">Carga
                            <select name="tipocarga" required>
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
                        <div class="container_amarelo">Data
                            <input type="date" name="envio_cargas" required>
                        </div>
                        <div class="container_amarelo">Quantidade
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
                    <?php foreach ($rows as $row): ?>
                        <div class="flex linha-registro" style="margin-bottom:8px;">
                            <div class="container_dados" style="flex:1;">
                                <input type="hidden" name="ids[]" value="<?= $row['idrelatorios'] ?>">
                                <input type="text" name="carga[<?= $row['idrelatorios'] ?>]" value="<?= htmlspecialchars($row['carga_relatorio']) ?>" />
                            </div>
                            <div class="container_dados" style="flex:1;">
                                <input type="date" name="data[<?= $row['idrelatorios'] ?>]" value="<?= htmlspecialchars($row['data_relatorio']) ?>" />
                            </div>
                            <div class="container_dados" style="flex:1;">
                                <input type="number" name="quantidade[<?= $row['idrelatorios'] ?>]" value="<?= (int)$row['quantidade_relatorio'] ?>" />
                            </div>
                        </div>
                    <?php endforeach; ?>