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

$passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
// Save $passwordHash instead of plain password to the database

if (password_verify($inputPassword, $userFromDb['password'])) {
    // Set session or JWT token
} else {
    // Return login error
}
