<?php
require_once __DIR__ . '/../db/conn.php';

$opcoes_cargas = [];
$trens = [];
$success = '';
$error = '';

if (isset($mysqli) && $mysqli) {
    $res = $mysqli->query("SELECT idcargas, tipo_carga, partida_carga, destino_carga FROM cargas");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $opcoes_cargas[] = $row;
        }
        $res->free();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $carga = trim($_POST['carga_trem'] ?? '');
        $capacidade = trim($_POST['capacidade_trem'] ?? '');
        $vagoes = trim($_POST['vagoes_trem'] ?? '');
        $estado = trim($_POST['estado_trem'] ?? '');
        $velocidade = trim($_POST['velocidade_trem'] ?? '');

        if ($carga && $capacidade && $vagoes && $estado && $velocidade) {
            $stmt = $mysqli->prepare("INSERT INTO trens (carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem) VALUES (?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param('sssss', $carga, $capacidade, $vagoes, $estado, $velocidade);
                if ($stmt->execute()) {
                    $success = 'Trem cadastrado com sucesso!';
                } else {
                    $error = 'Erro ao cadastrar: ' . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            $error = 'Preencha todos os campos.';
        }
    }

    $res_trens = $mysqli->query("SELECT idtrens, identificador_trem, carga_trem, capacidade_trem, vagoes_trem, estado_trem, velocidade_trem FROM trens ORDER BY idtrens DESC");
    if ($res_trens) {
        while ($row = $res_trens->fetch_assoc()) {
            $trens[] = $row;
        }
        $res_trens->free();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/gerenciamento_trens.css">
    <style>
        .tabela-container {
            margin-top: 40px;
            background-color: #FFC107;
            padding: 20px;
            border-radius: 8px;
        }
        .tabela-container h3 {
            color: #2C2C2C;
            margin-bottom: 15px;
        }
        .tabela-container table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        .tabela-container th {
            background-color: #2C2C2C;
            color: #FFC107;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        .tabela-container td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        .tabela-container tr:hover {
            background-color: #f9f9f9;
        }
        .tabela-container a {
            color: #2C2C2C;
            text-decoration: none;
            margin-right: 10px;
            font-weight: bold;
        }
        .tabela-container a:hover {
            text-decoration: underline;
        }
        .msg-sucesso {
            color: green;
            background-color: #e8f5e9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .msg-erro {
            color: red;
            background-color: #ffebee;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <section>
        <div class="container">
            <div class="container-accessibility-buttons">
                <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications" alt="">
                <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode" alt="">
            </div>
        </div>

        <div class="containerdois flex">
            <div>
                <h1 id="title">Gerenciamento de Trens</h1>
                <h2>Informações:</h2>
            </div>
        </div>
    </section>

    <section class="seletores">
        <?php if ($success): ?>
            <p class="msg-sucesso"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="msg-erro"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="gerenciamento_trens.php" method="POST">
            <h3>Informe a carga que o trem transportará:</h3>
            <select id="carga" name="carga_trem" required>
                <option value="">Selecione a carga...</option>
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
                <?php if (!empty($opcoes_cargas)): ?>
                    <?php foreach ($opcoes_cargas as $c): ?>
                        <option value="<?php echo htmlspecialchars($c['tipo_carga']); ?>">
                            <?php echo htmlspecialchars($c['tipo_carga'] . ' de ' . $c['partida_carga'] . ' para ' . $c['destino_carga']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <h3>Informe a capacidade máxima do trem:</h3>
            <select id="tamanho" name="capacidade_trem" required>
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

            <h3>Informe a quantidade de vagões:</h3>
            <select id="partida" name="vagoes_trem" required>
                <option value="">Selecione a quantidade...</option>
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

            <h3>Informe o estado atual:</h3>
            <select id="destino" name="estado_trem" required>
                <option value="">Selecione o estado...</option>
                <option value="Parado">Parado</option>
                <option value="Em rota">Em rota</option>
                <option value="Em manutenção">Em manutenção</option>
                <option value="Em carregamento">Em carregamento</option>
                <option value="Aguardando carga">Aguardando carga</option>
                <option value="Chegou ao destino">Chegou ao destino</option>
            </select>

            <h3>Informe a velocidade máxima:</h3>
            <select id="velocidade" name="velocidade_trem" required>
                <option value="">Selecione a velocidade...</option>
                <option value="60km/h">60km/h</option>
                <option value="80km/h">80km/h</option>
                <option value="100km/h">100km/h</option>
                <option value="120km/h">120km/h</option>
            </select>

            <input type="submit" value="Salvar"/>
        </form>

        
        </div>

        <div class="container-menu-bar">
            <div class="sections-menu-bar" id="press-effect">
                <img src="../src/assets/images/inicio-bar.png" alt="">
                <div id="incio"><a href="../public/pagina_inicial.php"><span>Início</span></a></div>
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
                <img src="../src/assets/images/funcionarios-bar.png" alt="">
                <a href="../public/funcionarios.php"><span>Funcionários</span></a>
            </div>
        </div>
    </section>
</body>
</html>