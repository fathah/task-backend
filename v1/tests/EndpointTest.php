<?php

require_once dirname(__FILE__).'../../../packages.php'; 


use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ApiEndpointTest extends TestCase {

    private $httpClient;

    public function setUp(): void {
        $this->httpClient = new Client(['base_uri' => 'http://localhost']); 
    }

    // construct and call setUp
    public function __construct(){
        $this->setUp();
    }

    public function testAuthenticationEndpoint($email, $pass) {
       try {
        $response = $this->httpClient->post('/task-backend/v1/api/auth/login.php', [
            'form_params' => [
                'email' => $email,
                'password' => $pass,
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        echo "✅ AuthenticationEndpoint: Test Passed\r\n";

       } catch (\Throwable $th) {
        echo "❌ AuthenticationEndpoint: Test Failed\r\n";
        throw $th;
       }
       
    }

    public function testRegistrationEndpoint($email, $pass, $role) {
       try {
        $response = $this->httpClient->post('/task-backend/v1/api/auth/register.php', [
            'form_params' => [
                'email' => $email,
                'password' => $pass,
                'role' => $role,
            ],
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        echo "✅ RegistrationEndpoint: Test Passed\r\n";
       } catch (\Throwable $th) {
        echo "❌ RegistrationEndpoint: Test Failed\r\n";
        throw $th;
       }
        
    }

    public function testTokenRefreshEndpoint($token) {
      
       try {
        $response = $this->httpClient->post('/task-backend/v1/api/auth/refresh-token.php', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        echo "✅ TokenRefresh: Test Passed\r\n";

       } catch (\Throwable $th) {
        echo "❌ TokenRefresh: Test Failed\r\n";
        throw $th;
       }
        
    }

    public function testUserProfileEndpoint($token) {
       
        try {
            $response = $this->httpClient->get('/task-backend/v1/api/user/profile.php', [
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]);
    
            $this->assertEquals(200, $response->getStatusCode());

            echo "✅ UserProfile: Test Passed\r\n";
        } catch (\Throwable $th) {
           echo "❌ UserProfile: Test Failed\r\n";
           throw $th;

        }
       
    }
}

$endpointTestObj = new ApiEndpointTest("testEndpoint");
$endpointTestObj->testAuthenticationEndpoint("fathah@task.com","my_password123");
$endpointTestObj->testRegistrationEndpoint("fathah@task.com","my_password123","user");
$endpointTestObj->testTokenRefreshEndpoint("");
$endpointTestObj->testUserProfileEndpoint("");

?>