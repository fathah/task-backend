<?php

require_once dirname(__FILE__).'../../../../packages.php'; 

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler {
    private static $secret = 'your_jwt_secret'; 

    public static function generateToken($payload) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Token valid for 1 hour

        $token = JWT::encode(
            [
                'iat' => $issuedAt,
                'iss' => 'fathah',
                'exp' => $expirationTime,
                'data' => $payload,
            ],
            self::$secret,
            'HS256'
        );

        return $token;
    }

    public static function validateToken($token) {
        try {

            $decoded = JWT::decode($token, new Key(self::$secret, 'HS256'));

            return $decoded->data;
        } catch (\Exception $e) {
            return false;
        }
    }
}

?>
