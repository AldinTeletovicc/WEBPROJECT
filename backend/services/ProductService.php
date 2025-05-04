<?php
class ProductService {
    public function validateProduct($data) {
        if (empty($data['name'])) throw new Exception('Product name is required');
        if (!isset($data['price']) || $data['price'] <= 0) throw new Exception('Price must be greater than zero');
        if (empty($data['category_id'])) throw new Exception('Category ID is required');
    }
}
