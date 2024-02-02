<?php

include dirname(__FILE__).'./JwtHandler.php';

class AuthMiddleware {
   

    
    public static function validateToken() {
        $token = self::extractHeaderToken();
       
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

    public static function extractHeaderToken() {
        $headers = getHeaders();

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

 function getHeaders() {
    if (function_exists('apache_request_headers')) {
        return apache_request_headers();
    }

    $headers = [];

    foreach ($_SERVER as $key => $value) {
        if (substr($key, 0, 5) === 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))))] = $value;
        }
    }

    return $headers;
}

?>
