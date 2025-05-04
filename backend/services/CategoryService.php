<?php
class CategoryService {
    public function validateCategory($data) {
        if (empty($data['name'])) throw new Exception('Category name is required');
        if (empty($data['description'])) throw new Exception('Category description is required');
    }
}
