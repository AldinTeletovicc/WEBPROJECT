<?php
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../config/Config.php'; // Add this line
require_once __DIR__ . '/../vendor/autoload.php'; // Add this for JWT

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::route('POST /auth/register', function() {
    $data = Flight::request()->data->getData();
    $service = new UserService();
    
    try {
        $service->validateUser($data);
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['role'] = 'user'; // Default role
        
        $dao = new UserDAO();
        $id = $dao->create($data);
        
        Flight::json(['id' => $id], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('POST /auth/login', function() {
    $data = Flight::request()->data->getData();
    $dao = new UserDAO();
    
    // Add this method to your UserDAO class
    $user = $dao->getByEmail($data['email']);
    
    if (!$user || !password_verify($data['password'], $user['password'])) {
        Flight::halt(401, "Invalid credentials");
    }
    
    $payload = [
        'user' => [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ],
        'exp' => time() + 3600 // 1 hour expiration
    ];
    
    $jwt = JWT::encode($payload, Config::JWT_SECRET(), 'HS256');
    Flight::json(['token' => $jwt]);
});
?>