<?php

$cwd2 = dirname(__FILE__);
require_once  $cwd2 . '../../Database/DatabaseConnector.php';


$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_DATABASE'];

$dbConnector = new DatabaseConnector($host, $username, $password, $database);

$pdo = $dbConnector->getPdo();



?>