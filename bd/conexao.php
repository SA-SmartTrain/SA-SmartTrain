<?php

/*Adicionar o ini php em casa no db*/

$inipath = php_ini_loaded_file();
$ini_array = parse_ini_file($inipath, true)["PHP"];

$dbName = 'smarttrain';
$dbUsername = 'smarttrain';
$dbPassword = $ini_array[""];
$dbHost = $ini_array[""];
$dbPort = 6306;

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

if ($conexao->connect_errno) {
    die("Conexão falhou: " . $conexao->connect_errno);
}
