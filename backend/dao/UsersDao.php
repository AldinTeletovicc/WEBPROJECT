<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("users");
    }

    public function createUser($name, $email, $password, $role) {
        return $this->create([
            "Name" => $name,
            "Email" => $email,
            "Password" => $password,
            "Role" => $role
        ]);
    }

    public function getAllUsers() {
        return $this->getAll();
    }

    public function getUserById($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE UserID = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $data) {
        return $this->update($userId, $data);
    }

    public function deleteUser($userId) {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE UserID = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
