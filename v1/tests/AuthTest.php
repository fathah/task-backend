<?php

require_once __DIR__ . '/../src/Auth/PasswordHasher.php';
require_once __DIR__ . '/../src/Auth/AuthMiddleware.php';

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {

    public function testJwtHandler() {
        $payload = [
            'id' => 123,
            'email' => 'fathah@task.com',
            'role' => 'admin'
        ];

        // Generate a token
        $token = JwtHandler::generateToken($payload);

        // Validate the generated token
        $decodedPayload = JwtHandler::validateToken($token);

         try {
            $this->assertEquals($payload['id'], $decodedPayload->id);
            $this->assertEquals($payload['email'], $decodedPayload->email);
            $this->assertEquals($payload['role'], $decodedPayload->role);
            echo "✅ JwtHandler: Test Passed\r\n";
         } catch (\Throwable $th) {
            echo "❌ JwtHandler: Test Failed\r\n";
            throw $th;
         }
    

    }

    public function testPasswordHasher() {

        $password = 'my_password123';
        $hashedPassword = PasswordHasher::hashPassword($password);

       try {
        // Assert that the hashed password is not equal to the original password
        $this->assertNotEquals($password, $hashedPassword);

        // Test password verification
        $isPasswordValid = PasswordHasher::verifyPassword($password, $hashedPassword);

        // Assert that the verification returns true
        $this->assertTrue($isPasswordValid);

        echo "✅ PasswordHasher: Test Passed\r\n";
       } catch (\Throwable $th) {
        echo "❌ PasswordHasher: Test Failed\r\n";
        throw $th;
       }
    }


    public function testAuthMiddleware() {
        // Generate a valid token for testing
        $payload = [
            'id' => 123,
            'email' => 'fathah@task.com',
            'role' => 'admin',
        ];

        $token = JwtHandler::generateToken($payload);

        // Validate the token using AuthMiddleware
        $isValidToken = AuthMiddleware::validateToken();

        try {
            $this->assertTrue($isValidToken);
            echo "✅ AuthMiddleware: Token Validation Test Passed\r\n";

            // Test token extraction
            $extractedToken = AuthMiddleware::extractHeaderToken();
            $this->assertEquals($token, $extractedToken);
            echo "✅ AuthMiddleware: Token Extraction Test Passed\r\n";
        } catch (\Throwable $th) {
            echo "❌ AuthMiddleware: Test Failed\r\n";
            throw $th;
        }
    }
}

$authObj = new AuthTest("AuthTest");
$authObj->testJwtHandler();
$authObj->testPasswordHasher();
$authObj->testAuthMiddleware();

?>
