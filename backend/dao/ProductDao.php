<?php
require_once 'BaseDao.php';

class ProductDao extends BaseDao {
    public function __construct() {
        parent::__construct("products");
    }

    public function createProduct($name, $description, $price, $categoryId) {
        return $this->create([
            "Name" => $name,
            "Description" => $description,
            "Price" => $price,
            "CategoryID" => $categoryId
        ]);
    }

    public function getAllProducts() {
        return $this->getAll();
    }

    public function getProductById($productId) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE ProductID = :id");
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct($productId, $data) {
        return $this->update($productId, $data);
    }

    public function deleteProduct($productId) {
        $stmt = $this->connection->prepare("DELETE FROM products WHERE ProductID = :id");
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
