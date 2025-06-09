<?php //Padrão do PHP = config.php ou conexao.php

    $dbHost = 'localhost'; //Host padrão
    $dbUsername = 'root'; //Username padrão
    $dbPassword = ''; //Se tiver senha no SQL
    $dbName = 'cadastro_miguelrocha'; //Nome do BD

    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName); //conexao do BD

    if($conexao->connect_errno) {
        die("Conexão falhou: " . $conexao->connect_errno);
    } //Aparecer na tela se ocorreu um erro ou não
    
?>