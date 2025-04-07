<?php

class BaseDao {
    protected $connection;
    private $table;
    private $primaryKey;

    public function __construct($table, $primaryKey = 'id') {
        $this->table = $table;
        $this->primaryKey = $primaryKey;

        $host = "localhost 2";
        $dbname = "projekatweb";
        $username = "root";
        $password = "12345678";

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
    }

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM $this->table");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM $this->table WHERE $this->primaryKey = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM $this->table WHERE $this->primaryKey = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $stmt = $this->connection->prepare("INSERT INTO $this->table ($columns) VALUES ($placeholders)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");

        $stmt = $this->connection->prepare("UPDATE $this->table SET $setClause WHERE $this->primaryKey = :id");
        $data[$this->primaryKey] = $id;

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }
}

?>
