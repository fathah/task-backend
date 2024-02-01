<?php

require_once 'JwtHandler.php';

class AuthMiddleware {
    public static function validateToken() {
        $token = self::extractTokenFromHeaders();

        if (!$token) {
            http_response_code(401); // Unauthorized
            echo json_encode(['success' => false, 'message' => 'Missing token']);
            exit;
        }

        try {
            $userData = JwtHandler::validateToken($token);

            if (!$userData) {
                http_response_code(401); // Unauthorized
                echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Token validation error: ' . $e->getMessage()]);
            exit;
        }
    }

    private static function extractTokenFromHeaders() {
        $headers = apache_request_headers();

        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $tokenParts = explode(' ', $authHeader);

            if (count($tokenParts) == 2 && $tokenParts[0] == 'Bearer') {
                return $tokenParts[1];
            }
        }

        return null;
    }
}

?>
