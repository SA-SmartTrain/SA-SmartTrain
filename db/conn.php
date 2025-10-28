<?php
$dbHost     = 'localhost';
$dbUsername = 'root';
$dbPassword = ''; 
$dbName     = 'smarttrain';

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
$conn = $mysqli;

if ($mysqli->connect_errno) {
    die("Falha na conexão: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');
?>