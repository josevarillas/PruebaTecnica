<?php
include_once '../config/Database.php';
include_once '../models/Employee.php';
include_once '../controllers/EmployeeController.php';

header("Content-Type: application/json; charset=UTF-8");
$db = (new Database())->getConnection();
$requestMethod = $_SERVER["REQUEST_METHOD"];
$employeeId = isset($_GET['id']) ? (int)$_GET['id'] : null;

$controller = new EmployeeController($db, $requestMethod, $employeeId);
$controller->processRequest();
?>
