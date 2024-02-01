<?php

require_once '../Auth/JwtHandler.php';
require_once '../Model/User.php';
require_once '../Includes/DB.php';

class UserProfileEndpoint {
    public function getUserProfile($token) {
        try {
            $userData = JwtHandler::validateToken($token);

            if (!$userData) {
                return ['success' => false, 'message' => 'Invalid or expired token'];
            }
            $userProfile = $this->fetchUserProfile($userData['id']);

            if ($userProfile) {
                return ['success' => true, 'data' => $userProfile];
            } else {
                return ['success' => false, 'message' => 'User profile not found'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error fetching user profile: ' . $e->getMessage()];
        }
    }

    private function fetchUserProfile($id) {
        global $pdo;

        $query = "SELECT id, email, role FROM users WHERE id = :id";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception('Error fetching user profile from the database: ' . $e->getMessage());
        }
    }
}

?>
