<?php
require_once __DIR__ . '/../services/ReviewService.php';
require_once __DIR__ . '/../dao/ReviewDAO.php';

Flight::route('GET /reviews', function() {
    $dao = new ReviewDAO();
    Flight::json($dao->getAll());
});

Flight::route('GET /reviews/@id', function($id) {
    $dao = new ReviewDAO();
    $review = $dao->getById($id);
    if ($review) {
        Flight::json($review);
    } else {
        Flight::json(['error' => 'Review not found'], 404);
    }
});

Flight::route('POST /reviews', function() {
    $data = Flight::request()->data->getData();
    $service = new ReviewService();
    try {
        $service->validateReview($data);
        $dao = new ReviewDAO();
        $id = $dao->create($data);
        Flight::json(['id' => $id], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /reviews/@id', function($id) {
    $data = Flight::request()->data->getData();
    $service = new ReviewService();
    try {
        $service->validateReview($data);
        $dao = new ReviewDAO();
        $dao->update($id, $data);
        Flight::json(['message' => 'Review updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /reviews/@id', function($id) {
    try {
        $dao = new ReviewDAO();
        $dao->delete($id);
        Flight::json(['message' => 'Review deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});