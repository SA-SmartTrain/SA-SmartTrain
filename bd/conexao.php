<?php 

    $dbHost = 'localhost'; 
    $dbUsername = 'root'; 
    $dbPassword = ''; 
    $dbName = 'cadastro_miguelrocha'; 
    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName); 

    if($conexao->connect_errno) {
        die("Conexão falhou: " . $conexao->connect_errno);
    } 
    
?>