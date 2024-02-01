<?php

$currentDir = dirname(__FILE__);

include $currentDir.'../../Includes/DB.php';
include $currentDir.'../../Auth/PasswordHasher.php';
include $currentDir.'../../Model/User.php';

class RegistrationEndpoint {
    public function registerUser($email, $password, $role) {
        if ( empty($password) || empty($email) || empty($role)) {
            return ['success' => false, 'message' => 'Missing Parameters'];
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
     
        $query = "INSERT INTO users(usr_email, usr_password, usr_role) VALUES (:email, :password, :role)";

        try {
            $role = $user->getRole();
            $email = $user->getEmail();
            $pass = $user->getPassword();

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $pass);
            $stmt->bindParam(':role', $role);

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('Error saving user to database: ' . $e->getMessage());
        }
    }
}

?>
