<?php

class HttpRequestHandler {
    public static function validateRequestMethod($expectedMethod) {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod !== $expectedMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            header('Content-Type: application/json');
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            exit;
        }
    }

    public static function getRequestBody() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            header("HTTP/1.1 400 Bad Request");
            exit;
        }

        return $data;
    }
}

?>
