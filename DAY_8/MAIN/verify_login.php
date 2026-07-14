<?php
require_once 'config.php';
$email = 'hr@ems.com';
$password = 'hr123';
$stmt = $conn->prepare('SELECT password FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
if (!$user) {
  echo 'User not found';
  exit;
}
$hash = $user['password'];
echo 'Stored hash: ' . htmlspecialchars($hash, ENT_QUOTES, 'UTF-8') . "<br>";
echo 'Verify hr123: ' . (password_verify($password, $hash) ? 'PASS' : 'FAIL');
?>