<?php

$currentDir = dirname(__FILE__);


include $currentDir.'../../Includes/DB.php';
include $currentDir.'../../Auth/PasswordHasher.php';
include $currentDir.'../../Model/User.php';
include $currentDir.'../../Auth/JwtHandler.php';



class AuthenticationEndpoint {
    public function authenticateUser($email, $password) {
        try {
            $user = $this->getUserByEmail($email);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found'];
            }

           
            if (PasswordHasher::verifyPassword($password, $user['usr_password'])) {
                // Password is correct, generate JWT token
                $token = JwtHandler::generateToken([
                    'id' => $user['usr_id'],
                    'email' => $user['usr_email'],
                    'role' => $user['usr_role']
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

        $query = "SELECT * FROM users WHERE usr_email = :email";

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
