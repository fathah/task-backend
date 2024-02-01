<?php

require_once '../../src/Utils/HTTPHandler.php';
require_once '../../src/Controller/Authentication.php';

try {
    HttpRequestHandler::validateRequestMethod('POST');

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $authenticationEndpoint = new AuthenticationEndpoint();

    $result = $authenticationEndpoint->authenticateUser($email, $password);

    if ($result['success']) {
        http_response_code(200); 
    } else {
        http_response_code(401); 
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500); 
    echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
}

?>
