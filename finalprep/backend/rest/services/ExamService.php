<?php
require_once __DIR__."/../dao/ExamDao.php";

class ExamService {
    protected $dao;

    public function __construct(){
        $this->dao = new ExamDao();
    }

    /** Service method to get employees performance report */
    public function employees_performance_report(){
        return $this->dao->employees_performance_report();
    }

    /** Service method to delete employee by id */
    public function delete_employee($employee_id){
        return $this->dao->delete_employee($employee_id);
    }

    /** Service method to edit employee data */
    public function edit_employee($employee_id, $data){
        return $this->dao->edit_employee($employee_id, $data);
    }

    /** Service method to get orders report */
    public function get_orders_report(){
        return $this->dao->get_orders_report();
    }

    /** Service method to get all products in a single order */
    public function get_order_details($order_id){
        return $this->dao->get_order_details($order_id);
    }
}
