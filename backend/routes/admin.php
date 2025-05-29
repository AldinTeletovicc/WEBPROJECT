<?php
Flight::group('/admin', function() {
    // Admin-only routes
    Flight::route('GET /users', function() {
        $dao = new UserDAO();
        Flight::json($dao->getAll());
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
    
    // Add more admin-only routes as needed
})->addMiddleware([AuthMiddleware::class, 'requireRole'], ['admin']);