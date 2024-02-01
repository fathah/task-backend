<?php

require_once '../../../src/Utils/HttpRequestHandler.php';
require_once '../../../src/Auth/AuthMiddleware.php';
require_once '../../../src/Controller/TokenRefresh.php';

try {
    // Validate the JWT token using the AuthMiddleware
    AuthMiddleware::validateToken();

    HttpRequestHandler::validateRequestMethod('POST');

    $oldToken = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $tokenRefreshEndpoint = new TokenRefresh();

    // Refresh the token
    $result = $tokenRefreshEndpoint->refreshToken($oldToken);

    // Check the token refresh result and set appropriate HTTP response code
    if ($result['success']) {
        http_response_code(200); // OK
    } else {
        http_response_code(401); // Unauthorized
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
}

?>
