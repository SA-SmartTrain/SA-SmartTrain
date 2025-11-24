<?php
include_once __DIR__ . '/../db/conn.php';

session_start();

// Verifica se o usuário já está logado
if (!isset($_SESSION["email_usuarios"])) {
    header('Location: ../public/login/cadastre-se-page.php'); // Redireciona para a página de login
    exit;
}

// Pega o email da sessão
$email = $_SESSION["email_usuarios"];

// Busca o nome no banco
$stmt = $conn->prepare("SELECT nome_usuarios FROM usuarios WHERE email_usuarios = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();
$nome_usuarios = $dados["nome_usuarios"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../src/assets/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/pagina_inicial.css">
    <link rel="stylesheet" href="../style/global/container-size-mobile.css">
    <title>SmartTrain - FAQ Perguntas Frequentes</title>
</head>

<body>
    <div class="container-size-mobile">
        <div class="container">
            <div class="container-accessibility-buttons">
                <img src="../src/assets/images/notifications.png" onclick="pushNot()" id="notifications">
                <img src="../src/assets/images/dark_and_white-mode.png" id="dark_and_white-mode">
            </div>
            <h1>Suporte FAQ - Perguntas Frequentes</h1>

        </div>

        <!-- Lista faq Inferior -->
        <main>
            <div class="container-faq">
                <div class="faq-header">
                    <h2>Ainda tem dúvidas? Nós podemos ajudar.</h2>
                </div>

                <div class="faq-list" id="faqList">
                    <!-- FAQ items will be inserted here by JavaScript -->
                </div>
            </div>
        </main>

        <div class="container-menu-bar" style="position: relative; top: -400px;">
            <div class="sections-menu-bar" id="press-effect">
                <img src="../src/assets/images/inicio-bar.png" alt="">
                <div id="incio">
                    <a href="../public/pagina_inicial.php"><span>Início</span></a>
                </div>
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
                <div id="funcionarios"><img src="../src/assets/images/funcionarios-bar.png" alt=""></div>
                <a href="../public/funcionarios.php"><span>Funcionários</span></a>
            </div>
        </div>
    </div>
</body>
<style>
    * {
        color: #2C2C2C;
    }

    body {
        background-color: #F0F0F0;
        overflow: hidden;
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


    h1 {
        margin-left: 35px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 26px;
        font-weight: bold;
    }

    .container-menu-bar {
        position: relative;
        margin-top: 25.6%;
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

    .container-sections {
        position: relative;
        top: 30px;
        margin-left: 35px;
    }

    .container-sections p {
        position: relative;
        top: 20px;
        font-size: 25px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .container-sections hr {
        position: relative;
        right: 1480px;
        width: 270px;
        height: 1px;
        border: 1px;
        border-top: 3px solid rgb(242, 211, 124);
        background-color: rgb(242, 211, 124);
        border-radius: 80px;
        margin-right: 120px;
    }

    .container-sections a {
        text-decoration: none;
    }

    .container-faq {
        /*Centralizar div*/
        margin: 0 auto;
        margin-top: 50px;
        width: 80%;
        margin-left: 150px;
    }

    .faq-header h2 {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 28px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .faq-list {
        border-top: 1px solid #e5e7eb;
    }

    .faq-item {
        border-bottom: 1px solid #e5e7eb;
    }

    .faq-button {
        width: 100%;
        padding: 24px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
        transition: background-color 0.2s ease;
    }

    .faq-button:hover {
        background-color: #f9fafb;
    }

    .faq-question {
        font-size: 18px;
        font-weight: 500;
        color: #111827;
        flex: 1;
        padding-right: 16px;
    }

    .faq-icon {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }

    .faq-icon svg {
        width: 100%;
        height: 100%;
        stroke: #4b5563;
        stroke-width: 2;
    }

    .faq-item.expanded .faq-icon {
        transform: rotate(180deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        color: #4b5563;
        line-height: 1.6;
        font-size: 16px;
    }


    .faq-item.expanded .faq-answer {
        max-height: 300px;
        /* ou mais, se quiser */
    }

    @media screen and (max-width: 960px) {

        .container-accessibility-buttons {
            position: relative;
            right: 1400px;
        }

        .container-sections hr {
            position: relative;
            right: 25px;
        }

        .container-menu-bar {
            position: relative;
            top: 30px;
            gap: 55px;
            right: 30px;
        }

    }

    @media screen and (max-width: 480px) {
        body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            background: #F0F0F0;
        }

        .container-accessibility-buttons {
            top: 32px;
            margin-left: 0;
            width: 100%;
            gap: 16px;
            justify-content: flex-end;
            padding-right: 18px;
            position: absolute;
            right: 0;
        }

        .container-accessibility-buttons img {
            margin-left: 0;
            width: 26px;
            height: 26px;
        }

        h1 {
            margin-left: 0;
            padding-left: 18px;
            font-size: 22px;
            margin-top: 32px;
            margin-bottom: 0;
        }

        .container-sections {
            margin-left: 0;
            top: 60px;
            padding: 0 18px;
        }

        .container-sections a {
            display: block;
        }

        .container-sections p {
            top: 0;
            font-size: 22px;
            margin-bottom: 0;
            margin-top: 28px;
            font-weight: 400;
            text-align: left;
        }

        .container-sections hr {
            right: 0;
            width: 90%;
            margin: 4px 0 0 0;
            border: none;
            border-top: 3px solid rgb(242, 211, 124);
            background: rgb(242, 211, 124);
            border-radius: 80px;
            height: 0;
            margin-right: 0;
        }

        .container-menu-bar {
            position: relative;
            top: 517px;
            gap: 40px;
        }

        .container-menu-bar img {
            left: 5px;
            width: 46px;
            height: 46px;
        }
    }
</style>
<script>
    const faqData = [{
            id: 1,
            question: "Onde posso acessar/alterar informações de cadastro?",
            answer: "Através do Dashboard, clicando em Meu Perfil"
        },
        {
            id: 2,
            question: "Sendo um Administrador, posso alterar informações de meus funcionários?",
            answer: "Sim, você está habilitado"
        },
        {
            id: 3,
            question: "Posso alterar informações de sensores, alarmes, trens e rotas após salvas? ",
            answer: "Todas as características salvas podem ser alteradas."
        },
        {
            id: 4,
            question: "É possível gerar relatórios de movimentação?",
            answer: "Sim, através da página Relatórios"
        },
        {
            id: 5,
            question: "Posso cadastrar novos sensores na linha de trem?",
            answer: "O aplicativo já oferece as opções de sensores disponíveis para utilização"
        },
        {
            id: 6,
            question: "As rotas de passagem do trem podem ser escolhidas conforme necessidade?",
            answer: "Sim, o maquinista pode definir sua rota a partir da logística necessária"
        },
        {
            id: 7,
            question: "Clientes podem acessar informações de transporte, formuladas pelo maquinista?",
            answer: "As informações são tratadas e disponibilizadas ao usuário "
        }
        
    ];

    function renderFAQ() {
        const faqList = document.getElementById('faqList');

        faqData.forEach(item => {
            const faqItem = document.createElement('div');
            faqItem.className = 'faq-item';
            faqItem.innerHTML = `
            <button class="faq-button" onclick="toggleFAQ(this)">
                <span class="faq-question">${item.question}</span>
                <div class="faq-icon">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </button>
            <div class="faq-answer">${item.answer}</div>
        `;
            faqList.appendChild(faqItem);
        });
    }

    function toggleFAQ(button) {
        const faqItem = button.closest('.faq-item');
        faqItem.classList.toggle('expanded');
    }

    document.addEventListener('DOMContentLoaded', renderFAQ);
</script>

</html>