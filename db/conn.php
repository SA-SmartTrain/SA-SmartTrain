<?php

$inipath = php_ini_loaded_file();
$ini_array = parse_ini_file($inipath, true)["PHP"];

$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName     = 'smarttrain';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_errno) {
    die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");