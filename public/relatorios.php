<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Relatórios - SGF</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 1000;
            padding: 10px 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: relative;
            height: calc(100vh - 56px);
            overflow-y: auto;
        }

        .main-content {
            padding-top: 20px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">SGF - Gestão Ferroviária</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link text-light">Bem-vindo(a), Usuário (Administrador)</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-danger btn-sm ms-2" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="funcionarios.php">Gerenciar Funcionários</a></li>
                        <li class="nav-item"><a class="nav-link" href="trens.php">Gerenciar Trens</a></li>
                        <li class="nav-item"><a class="nav-link" href="manutencoes.php">Gerenciar Manutenções</a></li>
                        <li class="nav-item"><a class="nav-link" href="sensores.php">Gerenciar Sensores</a></li>
                        <li class="nav-item"><a class="nav-link" href="estacoes.php">Gerenciar Estações</a></li>
                        <li class="nav-item"><a class="nav-link" href="trechos.php">Gerenciar Trechos Ferroviários</a></li>
                        <li class="nav-item"><a class="nav-link" href="rotas.php">Gerenciar Rotas</a></li>
                        <li class="nav-item"><a class="nav-link active" href="relatorios.php">Relatórios</a></li>
                    </ul>
                </div>
            </nav>

            <!-- CONTEÚDO PRINCIPAL -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="border-bottom pb-2 mb-4 pt-3">
                    <h1 class="h2">Gerenciamento de Relatórios</h1>
                </div>

                <h4 class="mb-4">Selecione o Relatório Desejado</h4>

                <div class="row">

                    <!-- 1 - Funcionários Ativos -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Funcionários Ativos</h5>
                                <p class="card-text">Gera um relatório detalhado sobre funcionários ativos.</p>
                                <div class="d-flex justify-content-between">
                                    <a href="relatorio_gerar.php?tipo=usuarios&formato=html" target="_blank" class="btn btn-sm btn-info">
                                        Visualizar
                                    </a>
                                    <a href="relatorio_gerar.php?tipo=usuarios&formato=pdf" class="btn btn-sm btn-danger">
                                        Baixar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2 - Trens em Manutenção -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Trens em Manutenção</h5>
                                <p class="card-text">Gera um relatório detalhado sobre trens em manutenção.</p>
                                <div class="d-flex justify-content-between">
                                    <a href="relatorio_gerar.php?tipo=manutencao&formato=html" target="_blank" class="btn btn-sm btn-info">
                                        Visualizar
                                    </a>
                                    <a href="relatorio_gerar.php?tipo=manutencao&formato=pdf" class="btn btn-sm btn-danger">
                                        Baixar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3 - Sensores Inativos -->
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Sensores</h5>
                                <p class="card-text">Gera um relatório detalhado sobre sensores.</p>
                                <div class="d-flex justify-content-between">
                                    <a href="relatorio_gerar.php?tipo=sensores&formato=html" target="_blank" class="btn btn-sm btn-info">
                                        Visualizar
                                    </a>
                                    <a href="relatorio_gerar.php?tipo=sensores&formato=pdf" class="btn btn-sm btn-danger">
                                        Baixar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>