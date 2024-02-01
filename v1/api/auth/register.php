<?php

require_once '../../src/Utils/HttpRequestHandler.php';
require_once '../../src/Controller/Registration.php';

try {
    HttpRequestHandler::validateRequestMethod('POST');

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $registrationEndpoint = new RegistrationEndpoint();

    $result = $registrationEndpoint->registerUser($username, $password, $email, $role);

    if ($result['success']) {
        http_response_code(201); 
    } else {
        http_response_code(400); 
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500); 
    echo json_encode(['success' => false, 'message' => 'Internal Server Error']);
}

?>
