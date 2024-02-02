<?php

require_once dirname(__FILE__).'../../../packages.php'; 
require_once __DIR__ . '/../src/Database/DatabaseConnector.php';


use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {

    public function testDatabaseConnection() {
        try {
            $dbConnector = new DatabaseConnector('localhost', 'root', '', 'task_db');

        // Get PDO instance
        $pdo = $dbConnector->getPdo();

        $this->assertNotNull($pdo);

        echo "✅ Database: Test Passed\r\n";
        } catch (\Throwable $th) {
           echo "❌ Database: Test Failed\r\n";
           throw $th;
        }
    }


}

$dbTestObj = new DatabaseTest("testDatabaseConnection");
$dbTestObj->testDatabaseConnection();

?>
