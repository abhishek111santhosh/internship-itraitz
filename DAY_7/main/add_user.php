<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

$host = "localhost";
$username = "root";
$password = "";
$dbName = "user_db";

$conn = new mysqli($host, $username, $password);
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

$createDbSql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($createDbSql) === FALSE) {
  die("Failed to create database '$dbName': " . $conn->error);
}
$conn->close();

$conn = new mysqli($host, $username, $password, $dbName);
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

$createTableSql = "CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if ($conn->query($createTableSql) === FALSE) {
  die("Failed to create users table: " . $conn->error);
}

if (isset($_POST['submit'])) {
  $name = $conn->real_escape_string($_POST['name'] ?? '');
  $email = $conn->real_escape_string($_POST['email'] ?? '');
  $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
  $role = $conn->real_escape_string($_POST['role'] ?? 'user');

  $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
  if ($conn->query($sql) === TRUE) {
    echo "User added! <a href='view_users.php'>View Users</a>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
<form method="POST">
  Name: <input type="text" name="name" required><br>
  Email: <input type="email" name="email" required><br>
  Password: <input type="password" name="password" required><br>
  Role:
  <select name="role">
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select><br>
  <button type="submit" name="submit">Add User</button>
</form>