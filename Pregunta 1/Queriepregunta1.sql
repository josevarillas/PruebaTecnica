CREATE DATABASE exam_db;
USE exam_db;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    position VARCHAR(100),
    salary DECIMAL(10, 2),
    email VARCHAR(100)
);

CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100)
);

CREATE TABLE employee_department (
    employee_id INT,
    department_id INT,
    FOREIGN KEY (employee_id) REFERENCES employees(id),
    FOREIGN KEY (department_id) REFERENCES departments(id)
);

INSERT INTO employees (name, position, salary, email) VALUES
('Alice', 'Manager', 75000.00, 'alice@example.com'),
('Bob', 'Developer', 60000.00, 'bob@example.com'),
('Charlie', 'Designer', 55000.00, 'charlie@example.com'),
('David', 'Tester', 50000.00, 'david@example.com'),
('Eva', 'Support', 45000.00, 'eva@example.com');

INSERT INTO departments (name) VALUES
('HR'),
('IT'),
('Support');

INSERT INTO employee_department (employee_id, department_id) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 3);


SELECT e.name AS employee_name, d.name AS department_name
FROM employees e
JOIN employee_department ed ON e.id = ed.employee_id
JOIN departments d ON ed.department_id = d.id;
