<?php
require_once __DIR__ . '/../services/ProductService.php';
require_once __DIR__ . '/../dao/ProductDAO.php';

Flight::route('GET /products', function() {
    $dao = new ProductDAO();
    Flight::json($dao->getAll());
});

Flight::route('GET /products/@id', function($id) {
    $dao = new ProductDAO();
    $product = $dao->getById($id);
    if ($product) {
        Flight::json($product);
    } else {
        Flight::json(['error' => 'Product not found'], 404);
    }
});

Flight::route('POST /products', function() {
    $data = Flight::request()->data->getData();
    $service = new ProductService();
    try {
        $service->validateProduct($data);
        $dao = new ProductDAO();
        $id = $dao->create($data);
        Flight::json(['id' => $id], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /products/@id', function($id) {
    $data = Flight::request()->data->getData();
    $service = new ProductService();
    try {
        $service->validateProduct($data);
        $dao = new ProductDAO();
        $dao->update($id, $data);
        Flight::json(['message' => 'Product updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /products/@id', function($id) {
    try {
        $dao = new ProductDAO();
        $dao->delete($id);
        Flight::json(['message' => 'Product deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});