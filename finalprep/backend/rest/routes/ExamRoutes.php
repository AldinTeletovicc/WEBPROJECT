<?php

Flight::route('GET /connection-check', function() {
    try {
        require_once __DIR__ . '/../dao/ExamDao.php';
        $dao = new ExamDao();
        echo json_encode(["status" => "ok", "message" => "Connected to database"]);
    } catch (Exception $e) {
        echo+ json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
});


Flight::route('GET /employees/performance', function() {
    try {
        require_once __DIR__ . '/../dao/ExamDao.php';
        $dao = new ExamDao();
        $employees = $dao->employees_performance_report();

        $response = [];
        foreach ($employees as $emp) {
            $response[] = [
                "id" => $emp["id"],
                "full_name" => $emp["full_name"],
                "total" => (float)$emp["total"]
            ];
        }

        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
});


Flight::route('DELETE /employee/delete/@employee_id', function($employee_id) {
    try {
        require_once __DIR__ . '/../dao/ExamDao.php';
        $dao = new ExamDao();
        $dao->delete_employee($employee_id);
        echo json_encode(["status" => "ok", "message" => "Employee deleted successfully"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
});



Flight::route('PUT /employee/edit/@employee_id', function($employee_id) {
    try {
        $data = Flight::request()->data->getData();

        require_once __DIR__ . '/../dao/ExamDao.php';
        $dao = new ExamDao();
        $dao->edit_employee($employee_id, $data);

        echo json_encode(["status" => "ok", "message" => "Employee updated successfully"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
});


Flight::route('GET /orders/report', function() {
    try {
        require_once __DIR__ . '/../dao/ExamDao.php';
        $dao = new ExamDao();
        $orders = $dao->get_orders_report();

        echo json_encode($orders);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
});

Flight::route('GET /order/details/@order_id', function($order_id) {
    try {
        require_once __DIR__ . '/../dao/ExamDao.php';
        $dao = new ExamDao();
        $details = $dao->get_order_details($order_id);

        echo json_encode($details);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
});


?>
