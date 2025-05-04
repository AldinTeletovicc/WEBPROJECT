<?php
class ContactService {
    public function validateContact($data) {
        if (empty($data['name'])) throw new Exception('Name is required');
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) throw new Exception('Valid email is required');
        if (empty($data['message'])) throw new Exception('Message is required');
    }
}
