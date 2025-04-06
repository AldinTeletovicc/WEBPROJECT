<?php
require_once 'BaseDao.php';

class ReviewDao extends BaseDao {
    public function __construct() {
        parent::__construct("reviews");
    }

    public function createReview($userId, $productId, $rating, $comment, $createdAt) {
        return $this->create([
            "UserID" => $userId,
            "ProductID" => $productId,
            "rating" => $rating,
            "Comment" => $comment,
            "CreatedAt" => $createdAt
        ]);
    }

    public function getAllReviews() {
        return $this->getAll();
    }

    public function getReviewById($reviewId) {
        $stmt = $this->connection->prepare("SELECT * FROM reviews WHERE ReviewID = :id");
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReview($reviewId, $data) {
        return $this->update($reviewId, $data);
    }

    public function deleteReview($reviewId) {
        $stmt = $this->connection->prepare("DELETE FROM reviews WHERE ReviewID = :id");
        $stmt->bindParam(':id', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
