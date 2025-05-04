<?php
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../dao/UserDAO.php';

Flight::route('GET /users', function() {
    $dao = new UserDAO();
    Flight::json($dao->getAll());
});

Flight::route('GET /users/@id', function($id) {
    $dao = new UserDAO();
    $user = $dao->getById($id);
    if ($user) {
        Flight::json($user);
    } else {
        Flight::json(['error' => 'User not found'], 404);
    }
});

Flight::route('POST /users', function() {
    $data = Flight::request()->data->getData();
    $service = new UserService();
    try {
        $service->validateUser($data);
        $dao = new UserDAO();
        $id = $dao->create($data);
        Flight::json(['id' => $id], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /users/@id', function($id) {
    $data = Flight::request()->data->getData();
    $service = new UserService();
    try {
        $service->validateUser($data);
        $dao = new UserDAO();
        $dao->update($id, $data);
        Flight::json(['message' => 'User updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /users/@id', function($id) {
    try {
        $dao = new UserDAO();
        $dao->delete($id);
        Flight::json(['message' => 'User deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});