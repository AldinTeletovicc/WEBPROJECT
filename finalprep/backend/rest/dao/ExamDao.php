<?php

class ExamDao {

    private $conn;

    /**
     * constructor of dao class
     */
    public function __construct(){
    try {
        $servername = "localhost";
        $username = "root";
        $password = "1234";
        $schema = "classicmodels";
        $port = 3306;

        $this->conn = new PDO("mysql:host=$servername;port=$port;dbname=$schema", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

    /** TODO
     * Implement DAO method used to get employees performance report
     */
  public function employees_performance_report(){
      $stmt = $this->conn->prepare("
          SELECT 
              e.employeeNumber AS id,
              CONCAT(e.firstName, ' ', e.lastName) AS full_name,
              IFNULL(SUM(c.creditLimit), 0) AS total
          FROM employees e
          LEFT JOIN customers c ON e.employeeNumber = c.salesRepEmployeeNumber
          GROUP BY e.employeeNumber
          ORDER BY e.employeeNumber
      ");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }



    /** TODO
     * Implement DAO method used to delete employee by id
     */
    public function delete_employee($employee_id) {
        $stmt = $this->conn->prepare("DELETE FROM employees WHERE employeeNumber = :id");
        $stmt->bindParam(':id', $employee_id);
        $stmt->execute();
    }

    /** TODO
     * Implement DAO method used to edit employee data
     */
    public function edit_employee($employee_id, $data){
        $stmt = $this->conn->prepare("
            UPDATE employees SET 
                firstName = :firstName,
                lastName = :lastName,
                email = :email,
                jobTitle = :jobTitle
            WHERE employeeNumber = :id
        ");
        $stmt->bindParam(':firstName', $data['firstName']);
        $stmt->bindParam(':lastName', $data['lastName']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':jobTitle', $data['jobTitle']);
        $stmt->bindParam(':id', $employee_id);
        $stmt->execute();
    }

    /** TODO
     * Implement DAO method used to get orders report
     */
    public function get_orders_report() {
        $stmt = $this->conn->prepare("
            SELECT 
                o.orderNumber,
                o.orderDate,
                o.status,
                IFNULL(SUM(od.quantityOrdered * od.priceEach), 0) AS total
            FROM orders o
            JOIN orderdetails od ON o.orderNumber = od.orderNumber
            GROUP BY o.orderNumber
            ORDER BY o.orderDate DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** TODO
     * Implement DAO method used to get all products in a single order
     */
  public function get_order_details($order_id) {
      $stmt = $this->conn->prepare("
          SELECT 
              p.productName,
              od.quantityOrdered,
              od.priceEach,
              (od.quantityOrdered * od.priceEach) AS total
          FROM orderdetails od
          JOIN products p ON od.productCode = p.productCode
          WHERE od.orderNumber = :order_id
      ");
      $stmt->bindParam(':order_id', $order_id);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

}
?>
