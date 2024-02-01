<?php

class PasswordHasher {
    public static function hashPassword($password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($hashedPassword === false) {
            throw new Exception('Password hash failure');
        }

        return $hashedPassword;
    }

    public static function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}

?>
