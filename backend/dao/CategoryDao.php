<?php
require_once 'BaseDao.php';

class CategoryDao extends BaseDao {
    public function __construct() {
        parent::__construct("categories");
    }

    public function createCategory($categoryName) {
        return $this->create([
            "CategoryName" => $categoryName
        ]);
    }

    public function getAllCategories() {
        return $this->getAll();
    }

    public function getCategoryById($categoryId) {
        $stmt = $this->connection->prepare("SELECT * FROM categories WHERE CategoryID = :id");
        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory($categoryId, $categoryName) {
        $stmt = $this->connection->prepare("UPDATE categories SET CategoryName = :name WHERE CategoryID = :id");
        $stmt->bindParam(':name', $categoryName);
        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function deleteCategory($categoryId) {
        $stmt = $this->connection->prepare("DELETE FROM categories WHERE CategoryID = :id");
        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
