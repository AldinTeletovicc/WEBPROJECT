<?php
class ReviewService {
    public function validateReview($data) {
        if (empty($data['user_id'])) throw new Exception('User ID is required');
        if (empty($data['product_id'])) throw new Exception('Product ID is required');
        if (!isset($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) throw new Exception('Rating must be between 1 and 5');
    }
}

