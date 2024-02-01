<?php

$currentDir = dirname(__FILE__);
require_once $currentDir . '/Database/DatabaseConnector.php';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'task_db';

$dbConnector = new DatabaseConnector($host, $username, $password, $database);

$pdo = $dbConnector->getPdo();



?>