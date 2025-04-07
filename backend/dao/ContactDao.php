<?php
require_once 'BaseDao.php';

class ContactDao extends BaseDao {
    public function __construct() {
        parent::__construct("contact");
    }

    public function createContact($userId, $name, $email, $message, $createdAt) {
        return $this->create([
            "UserID" => $userId,
            "Name" => $name,
            "Email" => $email,
            "Message" => $message,
            "CreatedAt" => $createdAt
        ]);
    }

    public function getAllContacts() {
        return $this->getAll();
    }

    public function getContactById($contactId) {
        $stmt = $this->connection->prepare("SELECT * FROM contact WHERE ContactID = :id");
        $stmt->bindParam(':id', $contactId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateContact($contactId, $data) {
        return $this->update($contactId, $data);
    }

    public function deleteContact($contactId) {
        $stmt = $this->connection->prepare("DELETE FROM contact WHERE ContactID = :id");
        $stmt->bindParam(':id', $contactId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
