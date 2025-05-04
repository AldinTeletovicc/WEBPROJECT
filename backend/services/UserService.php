<?php
class UserService {
    public function validateUser($data) {
        if (empty($data['email'])) throw new Exception('Email is required');
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) throw new Exception('Invalid email format');
        if (empty($data['password'])) throw new Exception('Password is required');
    }

    public function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
