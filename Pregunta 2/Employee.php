<?php
class Employee {
    private $conn;
    private $table_name = "employees";

    public $id;
    public $name;
    public $position;
    public $salary;
    public $email;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        // Validación del email nueva
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, position=:position, salary=:salary, email=:email";
        $stmt = $this->conn->prepare($query);
        // Sanitización de los datos
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->position=htmlspecialchars(strip_tags($this->position));
        $this->salary=htmlspecialchars(strip_tags($this->salary));
        $this->email=htmlspecialchars(strip_tags($this->email));
        // Asignación de los valores
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":position", $this->position);
        $stmt->bindParam(":salary", $this->salary);
        $stmt->bindParam(":email", $this->email);
        // Ejecución de la consulta
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, position=:position, salary=:salary, email=:email WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->position=htmlspecialchars(strip_tags($this->position));
        $this->salary=htmlspecialchars(strip_tags($this->salary));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":position", $this->position);
        $stmt->bindParam(":salary", $this->salary);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
