<?php 
    /*Adicionar o it php em casa no db*/
    $dbHost = 'localhost'; 
    $dbUsername = 'root'; 
    $dbPassword = 'root'; 
    $dbName = 'smarttrain'; 
    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName); 

    if($conexao->connect_errno) {
        die("Conexão falhou: " . $conexao->connect_errno);
    } 
    
?>