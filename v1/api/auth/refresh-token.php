<?php

require_once '../../src/Utils/HTTPHandler.php';
require_once '../../src/Controller/TokenRefresh.php';
require_once '../../src/Auth/AuthMiddleware.php';



try {
    AuthMiddleware::validateToken();


    HttpRequestHandler::validateRequestMethod('POST');

    $currentToken = AuthMiddleware::extractHeaderToken();

    $tokenRefreshEndpoint = new TokenRefresh();
    // Refresh the token
    $result = $tokenRefreshEndpoint->refreshToken($currentToken);

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
