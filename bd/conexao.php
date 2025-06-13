<?php

/*Adicionar o ini php em casa no db*/

$config = parse_ini_file('config.ini', true);

$inipath = php_ini_loaded_file();
$ini_array = parse_ini_file('config.ini', true);

$dbConfig = $config['database'];

$dbName = 'smarttrain';
$dbUsername = 'smarttrain';
$dbPassword = $ini_array["database"]["password"];
$dbHost = $ini_array["database"]["host"];
$dbPort = 6306;

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

if ($conexao->connect_errno) {
    die("Conexão falhou: " . $conexao->connect_errno);
}
