<?php

require_once dirname(__FILE__).'../../../../packages.php'; 

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret = $_ENV['JWT_SECRET'];

class JwtHandler {
    

   
    public static function generateToken($payload) {
        global $secret;
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token valid for 1 hour

        $token = JWT::encode(
            [
                'iat' => $issuedAt,
                'iss' => 'fathah',
                'exp' => $expirationTime,
                'data' => $payload,
            ],
            $secret,
            'HS256'
        );

        return $token;
    }

    public static function validateToken($token) {
        global $secret;

        try {

            $decoded = JWT::decode($token, new Key($secret, 'HS256'));

            return $decoded->data;
        } catch (\Exception $e) {
            return false;
        }
    }
}

?>
