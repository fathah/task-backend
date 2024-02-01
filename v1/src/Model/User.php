<?php

class User {
    private $id;
    private $password;
    private $email;
    private $role;

    public function __construct($id, $email, $password,  $role) {
        $this->id = $id;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;

    }

    public function getId() {
        return $this->id;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }


    public function toArray() {
        return [
            'id' => $this->id,
            'password' => $this->password,
            'email' => $this->email,
            'role' => $this->role
        ];
    }
}

?>
