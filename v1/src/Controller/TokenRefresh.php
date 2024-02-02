<?php


class TokenRefresh {
    public function refreshToken($oldToken) {
        try {
            $userData = JwtHandler::validateToken($oldToken);

            if (!$userData) {
                return ['success' => false, 'message' => 'Invalid or expired token'];
            }

            $newToken = JwtHandler::generateToken($userData);

            return ['success' => true, 'token' => $newToken];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error refreshing token: ' . $e->getMessage()];
        }
    }
}

?>
