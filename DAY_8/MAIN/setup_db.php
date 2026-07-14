<?php
header("Content-Type: text/html; charset=UTF-8");

$host = "localhost";
$user = "root";
$pass = "";
$dbName = "ems_db";

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
  die("Connection Failed: " . $conn->connect_error);
}

// Create Database
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($dbName);

// Table 1: users (Credentials & Roles)
$conn->query("CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('hr', 'employee') NOT NULL DEFAULT 'employee',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Table 2: employees (Profile Records with Foreign Key)
$conn->query("CREATE TABLE IF NOT EXISTS employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  full_name VARCHAR(255) NOT NULL,
  phone VARCHAR(50) DEFAULT NULL,
  department VARCHAR(100) DEFAULT NULL,
  designation VARCHAR(100) DEFAULT NULL,
  joining_date DATE DEFAULT CURRENT_DATE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Seed Initial Accounts (1 HR, 2 Employees)
$seedData = [
  [
    'email' => 'hr@ems.com',
    'password' => password_hash('hr123', PASSWORD_DEFAULT),
    'role' => 'hr',
    'name' => 'HR Administrator',
    'phone' => '+91 9876543210',
    'dept' => 'Human Resources',
    'desig' => 'HR Manager'
  ],
  [
    'email' => 'kripa@itraitz.com',
    'password' => password_hash('emp123', PASSWORD_DEFAULT),
    'role' => 'employee',
    'name' => 'Kripa Lakshmy D',
    'phone' => '+91 9876543211',
    'dept' => 'IT',
    'desig' => 'Programmer'
  ],
  [
    'email' => 'gowtham@itraitz.com',
    'password' => password_hash('emp123', PASSWORD_DEFAULT),
    'role' => 'employee',
    'name' => 'Gowtham',
    'phone' => '+91 9876543212',
    'dept' => 'AI',
    'desig' => 'Data Analyst'
  ]
];

$userStmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE password = VALUES(password), role = VALUES(role)");
$empStmt = $conn->prepare("INSERT INTO employees (user_id, full_name, phone, department, designation) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE full_name = VALUES(full_name), phone = VALUES(phone), department = VALUES(department), designation = VALUES(designation)");
$idStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");

foreach ($seedData as $data) {
  $userStmt->bind_param("sss", $data['email'], $data['password'], $data['role']);
  $userStmt->execute();

  $idStmt->bind_param("s", $data['email']);
  $idStmt->execute();
  $idStmt->bind_result($userId);
  $idStmt->fetch();
  $idStmt->free_result();

  if ($userId) {
    $empStmt->bind_param("issss", $userId, $data['name'], $data['phone'], $data['dept'], $data['desig']);
    $empStmt->execute();
  }
}

$idStmt->close();
$userStmt->close();
$empStmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Database Initialized</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center vh-100">
  <div class="container text-center" style="max-width: 550px;">
    <div class="card shadow-sm p-4 border-0 rounded-3">
      <h3 class="text-success fw-bold mb-2">✔ System Database Ready!</h3>
      <p class="text-muted small">Database <strong>ems_db</strong> and relational tables have been structured.</p>
      <hr>
      <div class="text-start bg-light p-3 rounded mb-4 small border">
        <p class="mb-2"><strong>HR Credentials:</strong><br>Email: <code>hr@ems.com</code> | Password:
          <code>hr123</code>
        </p>
        <p class="mb-0"><strong>Employee Credentials:</strong><br>Email: <code>kripa@itraitz.com</code> | Password:
          <code>emp123</code>
        </p>
      </div>
      <a href="index.php" class="btn btn-primary fw-bold w-100 py-2">Proceed to Portal Login</a>
    </div>
  </div>
</body>

</html>