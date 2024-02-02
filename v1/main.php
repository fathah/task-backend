<?php

$cwd = dirname(__FILE__);

require_once $cwd.'/../packages.php';

use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(dirname($cwd.'../'));
$dotenv->load();


?>