<?php

require_once __DIR__ . '/../db/conn.php';
require_once 'dompdf/autoload.inc.php';

$tipo_relatorio = $_GET['tipo'] ?? '';
$formato = $_GET['formato'] ?? 'html';

if (empty($tipo_relatorio)) {
    $_SESSION['erro_relatorio'] = "Tipo de relatório não especificado.";
    header("Location: relatorios.php");
    exit;
}

function gerar_dados_relatorio($conn, $tipo)
{
    $dados = ['titulo' => '', 'colunas' => [], 'registros' => []];

    switch ($tipo) {
        case 'usuarios': //Arrumar
            $dados['titulo'] = "Relatório de Usuários Ativos";
            $dados['colunas'] = ['ID', 'Nome', 'E-mail', 'CPF', 'Perfil', 'Telefone', 'Endereço'];
            $sql = "SELECT idusuarios, nome_usuarios, email_usuarios, cpf_usuarios, perfil, telefone_usuario, endereco_usuario
                    FROM usuarios
                    ORDER BY nome_usuarios ASC";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $dados['registros'][] = [
                    $row['idusuarios'],
                    $row['nome_usuarios'],
                    $row['email_usuarios'],
                    $row['cpf_usuarios'],
                     $row['perfil'],
                      $row['telefone_usuario'],
                       $row['endereco_usuario'],
                ];
            }
            break;

        case 'manutencao': //Arrumar
            $dados['titulo'] = "Relatório de Trens em Manutenção";
            $dados['colunas'] = ['ID da Manutenção', 'Horário', 'Observações', 'Linha', 'ID do Usuário'];
            $sql = "SELECT 
                        idmanutencao, horario_manutencao, observacao_manutencao, linha_manutencao, idusuarios
                    FROM manutencao 
                    ORDER BY idmanutencao ASC";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $dados['registros'][] = [
                    $row['idmanutencao'],
                    $row['horario_manutencao'],
                    $row['observacao_manutencao'],
                    $row['linha_manutencao'],
                    $row['idusuarios'],
                ];
            }
            break;

        case 'sensores': //Arrumar
            $dados['titulo'] = "Relatório de Sensores";
            $dados['colunas'] = ['Identificação', 'Tipo', 'Localização', 'Data', 'Observação'];
            $sql = "SELECT 
                        idsensores, tipo_sensor, localizacao_sensor, data_sensor, observacao_sensor
                    FROM sensores
                    ORDER BY idsensores ASC";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $dados['registros'][] = [
                    $row['idsensores'],
                    ucfirst($row['tipo_sensor']),
                    $row['localizacao_sensor'],
                    date('d/m/Y', strtotime($row['data_sensor'])),
                    $row['observacao_sensor'],
                ];
            }
            break;

        default:
            return false;
    }

    return $dados;
}

function gerar_html_relatorio($dados)
{
    $html = '
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . htmlspecialchars($dados['titulo']) . '</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { font-size: 10pt; padding: 20px; }
            .header { text-align: center; margin-bottom: 30px; }
            .header h1 { font-size: 18pt; }
            .header p { font-size: 10pt; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #dee2e6; padding: 8px; text-align: left; }
            th { background-color: #f8f9fa; }
            .footer { margin-top: 30px; font-size: 8pt; text-align: center; }
            @media print {
                .btn { display: none; }
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>' . htmlspecialchars($dados['titulo']) . '</h1>
            <p>Gerado em: ' . date('d/m/Y H:i:s') . ' | Usuário: ' . htmlspecialchars($_SESSION['nome_usuario']) . '</p>
        </div>
        
        <div class="container-fluid">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>';

    foreach ($dados['colunas'] as $coluna) {
        $html .= '<th>' . htmlspecialchars($coluna) . '</th>';
    }

    $html .= '
                    </tr>
                </thead>
                <tbody>';

    if (empty($dados['registros'])) {
        $html .= '<tr><td colspan="' . count($dados['colunas']) . '" class="text-center">Nenhum registro encontrado.</td></tr>';
    } else {
        foreach ($dados['registros'] as $registro) {
            $html .= '<tr>';
            foreach ($registro as $valor) {
                $html .= '<td>' . htmlspecialchars($valor) . '</td>';
            }
            $html .= '</tr>';
        }
    }

    $html .= '
                </tbody>
            </table>
        </div>
        
        <div class="footer">
            Sistema de Gestão Ferroviária (SGF) - Relatório Confidencial
        </div>
        
        <div class="text-center mt-5">
            <button class="btn btn-primary" onclick="window.print()">Imprimir / Salvar como PDF</button>
            <a href="relatorios.php" class="btn btn-secondary">Voltar</a>
        </div>
    </body>
    </html>';

    return $html;
}

$dados_relatorio = gerar_dados_relatorio($conn, $tipo_relatorio);

if (!$dados_relatorio) {
    $_SESSION['erro_relatorio'] = "Tipo de relatório inválido.";
    header("Location: relatorios.php");
    exit;
}

$html_content = gerar_html_relatorio($dados_relatorio);

if ($formato == 'html') {
    echo $html_content;
} elseif ($formato == 'pdf') {

    $temp_html_file = sys_get_temp_dir() . '/' . uniqid('relatorio_') . '.html';
    file_put_contents($temp_html_file, $html_content);

    $nome_arquivo = 'relatorio_' . $tipo_relatorio . '_' . date('Ymd_His') . '.pdf';

    $pdf_output_path = sys_get_temp_dir() . '/' . $nome_arquivo;

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');

/*     echo "
    %PDF-1.4
    %Simulação de Conteúdo PDF
    
    O relatório '" . $dados_relatorio['titulo'] . "' foi gerado com sucesso.
    
    Em um ambiente real, o servidor PHP usaria uma biblioteca (como Dompdf ou TCPDF) para converter o HTML em um arquivo PDF binário e enviá-lo para download.
    
    O conteúdo do relatório é:
    " . print_r($dados_relatorio['registros'], true) . "
    "; */

    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml($html_content);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream($nome_arquivo, array("Attachment" => true));

} else {
    $_SESSION['erro_relatorio'] = "Formato de relatório inválido.";
    header("Location: relatorios.php");
    exit;
}

mysqli_close($conn);
exit;
