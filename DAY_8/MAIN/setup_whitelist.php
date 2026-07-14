<?php
require_once 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS `allocated_workers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `department_scope` VARCHAR(100) DEFAULT NULL,
  `designation_scope` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
  // Insert a test worker so you can test registration right away
  $conn->query("INSERT IGNORE INTO `allocated_workers` (`email`, `department_scope`, `designation_scope`) VALUES ('test.worker@company.com', 'IT', 'Software Engineer')");
  echo "<h3 style='color:green; font-family:sans-serif;'>✔ Whitelist Table Created & Seeded!</h3>";
  echo "<p style='font-family:sans-serif;'>Authorized email added: <b>test.worker@company.com</b><br><a href='index.php'>Go to Login Page</a></p>";
} else {
  echo "Error creating table: " . $conn->error;
}
?>