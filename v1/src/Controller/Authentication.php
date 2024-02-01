<?php

require_once '../Auth/JwtHandler.php';
require_once '../Auth/PasswordHasher.php';
require_once '../Model/User.php';
require_once '../Includes/DB.php'; 

class AuthenticationEndpoint {
    public function authenticateUser($email, $password) {
        try {
            $user = $this->getUserByEmail($email);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found'];
            }

           
            if (PasswordHasher::verifyPassword($password, $user['password'])) {
                // Password is correct, generate JWT token
                $token = JwtHandler::generateToken([
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ]);

                return ['success' => true, 'token' => $token];
            } else {
                return ['success' => false, 'message' => 'Incorrect password'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error authenticating user: ' . $e->getMessage()];
        }
    }

    private function getUserByEmail($email) {
        global $pdo;

        $query = "SELECT * FROM users WHERE email = :email";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception('Error fetching user from the database: ' . $e->getMessage());
        }
    }
}

?>
