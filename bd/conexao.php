<?php

$ini_array = parse_ini_file(__DIR__ . '/../bd/config.ini', true);

$dbUsername = 'smarttrain';
$dbHost     = $ini_array['database']['host'];
$dbPassword = $ini_array['database']['password'];
$dbName     = 'smarttrain';
$dbPort     = 6306;

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

if ($conexao->connect_errno) {
    die("Falha na conexão: " . $conexao->connect_error);
}