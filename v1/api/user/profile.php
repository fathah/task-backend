<?php

require_once '../../src/Utils/HTTPHandler.php';
require_once '../../src/Auth/AuthMiddleware.php';
require_once '../../src/Controller/UserProfile.php';




try {

    AuthMiddleware::validateToken();

    HttpRequestHandler::validateRequestMethod('GET');

    // Get the user data from the validated token
    $token = AuthMiddleware::extractHeaderToken();

    $userProfileEndpoint = new UserProfileEndpoint();
    
    $result = $userProfileEndpoint->getUserProfile($token);

    if ($result['success']) {
        http_response_code(200); // OK
    } else {
        http_response_code(404); // Not Found
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
}

?>
