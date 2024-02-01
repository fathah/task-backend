<?php

class HttpRequestHandler {
    public static function validateRequestMethod($expectedMethod) {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestMethod !== $expectedMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            header("Allow: $expectedMethod");
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
