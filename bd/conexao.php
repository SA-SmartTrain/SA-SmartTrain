<?php 

    $dbHost = 'localhost'; 
    $dbUsername = 'root'; 
    $dbPassword = 'root'; 
    $dbName = 'db_smartrain'; 
    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName); 

    if($conexao->connect_errno) {
        die("Conexão falhou: " . $conexao->connect_errno);
    } 
    
?>