<?php
class EmployeeController {
    private $db;
    private $requestMethod;
    private $employeeId;
    private $employee;

    public function __construct($db, $requestMethod, $employeeId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->employeeId = $employeeId;
        $this->employee = new Employee($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->employeeId) {
                    $response = $this->getEmployee($this->employeeId);
                } else {
                    $response = $this->getAllEmployees();
                }
                break;
            case 'POST':
                $response = $this->createEmployee();
                break;
            case 'PUT':
                $response = $this->updateEmployee($this->employeeId);
                break;
            case 'DELETE':
                $response = $this->deleteEmployee($this->employeeId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllEmployees() {
        $result = $this->employee->read();
        $employees = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $employee_item = array(
                "id" => $id,
                "name" => $name,
                "position" => $position,
                "salary" => $salary,
                "email" => $email
            );
            array_push($employees, $employee_item);
        }
        return $this->okResponse($employees);
    }

    private function getEmployee($id) {
        // Implementación similar a getAllEmployees, pero filtrando por id.
    }

    private function createEmployee() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateEmployee($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->employee->name = $input['name'];
        $this->employee->position = $input['position'];
        $this->employee->salary = $input['salary'];
        $this->employee->email = $input['email'];
        if ($this->employee->create()) {
            return $this->okResponse(["message" => "Employee created successfully."]);
        }
        return $this->unprocessableEntityResponse();
    }

    private function updateEmployee($id) {
        // Implementación similar a createEmployee, pero actualizando un registro existente
    }

    private function deleteEmployee($id) {
        if ($this->employee->delete()) {
            return $this->okResponse(["message" => "Employee deleted successfully."]);
        }
        return $this->notFoundResponse();
    }

    private function validateEmployee($input) {
        return isset($input['name']) && isset($input['position']) && isset($input['salary']) && isset($input['email']);
    }

    private function okResponse($data) {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($data);
        return $response;
    }

    private function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => 'Resource not found'
        ]);
        return $response;
    }
}
?>
