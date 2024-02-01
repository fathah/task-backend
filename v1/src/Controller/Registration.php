<?php

// Include necessary files and classes
include '../Includes/DB.php';
include '../Auth/PasswordHasher.php';
include '../Model/User.php';

class RegistrationEndpoint {
    public function registerUser($email, $password, $role) {
        if ( empty($password) || empty($email)) {
            return ['success' => false, 'message' => 'Incomplete registration information'];
        }

        $hashedPassword = PasswordHasher::hashPassword($password);
        $user = new User(null, $email, $hashedPassword,  $role);

        try {
            if ($this->saveUserToDatabase($user)) {
                return ['success' => true, 'message' => 'Registration successful'];
            } else {
                return ['success' => false, 'message' => 'Registration failed'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error during registration: ' . $e->getMessage()];
        }
    }

    private function saveUserToDatabase(User $user) {
        global $pdo;
     
        $query = "INSERT INTO users (email, password, role) VALUES ( :email, :password, :role)";

        try {
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':password', $user->getPassword());
            $stmt->bindParam(':role', $user->getRole());

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('Error saving user to database: ' . $e->getMessage());
        }
    }
}

?>
