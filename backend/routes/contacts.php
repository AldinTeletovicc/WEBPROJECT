<?php
require_once __DIR__ . '/../services/ContactService.php';
require_once __DIR__ . '/../dao/ContactDAO.php';

Flight::route('GET /contacts', function() {
    $dao = new ContactDAO();
    Flight::json($dao->getAll());
});

Flight::route('GET /contacts/@id', function($id) {
    $dao = new ContactDAO();
    $contact = $dao->getById($id);
    if ($contact) {
        Flight::json($contact);
    } else {
        Flight::json(['error' => 'Contact not found'], 404);
    }
});

Flight::route('POST /contacts', function() {
    $data = Flight::request()->data->getData();
    $service = new ContactService();
    try {
        $service->validateContact($data);
        $dao = new ContactDAO();
        $id = $dao->create($data);
        Flight::json(['id' => $id], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /contacts/@id', function($id) {
    $data = Flight::request()->data->getData();
    $service = new ContactService();
    try {
        $service->validateContact($data);
        $dao = new ContactDAO();
        $dao->update($id, $data);
        Flight::json(['message' => 'Contact updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /contacts/@id', function($id) {
    try {
        $dao = new ContactDAO();
        $dao->delete($id);
        Flight::json(['message' => 'Contact deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});