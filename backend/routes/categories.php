<?php
require_once __DIR__ . '/../services/CategoryService.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';

Flight::route('GET /categories', function() {
    $dao = new CategoryDAO();
    Flight::json($dao->getAll());
});

Flight::route('GET /categories/@id', function($id) {
    $dao = new CategoryDAO();
    $category = $dao->getById($id);
    if ($category) {
        Flight::json($category);
    } else {
        Flight::json(['error' => 'Category not found'], 404);
    }
});

Flight::route('POST /categories', function() {
    $data = Flight::request()->data->getData();
    $service = new CategoryService();
    try {
        $service->validateCategory($data);
        $dao = new CategoryDAO();
        $id = $dao->create($data);
        Flight::json(['id' => $id], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /categories/@id', function($id) {
    $data = Flight::request()->data->getData();
    $service = new CategoryService();
    try {
        $service->validateCategory($data);
        $dao = new CategoryDAO();
        $dao->update($id, $data);
        Flight::json(['message' => 'Category updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /categories/@id', function($id) {
    try {
        $dao = new CategoryDAO();
        $dao->delete($id);
        Flight::json(['message' => 'Category deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});