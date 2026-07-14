<?php
require_once 'config.php';
$result = $conn->query('SELECT id, email, role, password FROM users');
if (!$result) {
  echo 'DB error: ' . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8');
  exit;
}
echo '<pre>';
while ($row = $result->fetch_assoc()) {
  echo 'id=' . $row['id'] . ' email=' . $row['email'] . ' role=' . $row['role'] . ' pass=' . substr($row['password'], 0, 20) . "...\n";
}
echo '</pre>';
?>