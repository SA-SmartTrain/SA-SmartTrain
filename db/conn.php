<?php

$inipath = php_ini_loaded_file();
$ini_array = parse_ini_file($inipath, true)["PHP"];

$dbUsername = 'smarttrain';
$dbHost     = $ini_array['database']['host'];
$dbPassword = $ini_array['database']['password'];
$dbName     = 'smarttrain';
$dbPort     = 6306;

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName, $dbPort);

if ($conn->connect_errno) {
    die("Falha na conexão: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");