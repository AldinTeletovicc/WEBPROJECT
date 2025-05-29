<?php
abstract class BaseService {
    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    // Basic validation that can be extended by child services
    protected function validateInput($data, $requiredFields) {
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Missing required field: " . $field);
            }
        }
        return true;
    }

    // Standard CRUD methods that child services can inherit or override
    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        $result = $this->dao->getById($id);
        if (!$result) {
            throw new Exception("Resource not found", 404);
        }
        return $result;
    }

    public function create($data) {
        return $this->dao->create($data);
    }

    public function update($id, $data) {
        $this->getById($id); // Verify exists first
        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        $this->getById($id); // Verify exists first
        return $this->dao->delete($id);
    }
}
?>