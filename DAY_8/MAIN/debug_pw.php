<?php
require_once 'config.php';
$email = 'hr@ems.com';
$password = 'hr123';
$stmt = $conn->prepare('SELECT password FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->bind_result($hash);
$stmt->fetch();
$stmt->close();

var_dump($hash);
echo 'length=' . strlen($hash) . "\n";
echo 'trimmed length=' . strlen(trim($hash)) . "\n";
echo 'equals trimmed=' . (var_export($hash === trim($hash), true)) . "\n";
echo 'verify raw=' . (password_verify($password, $hash) ? 'PASS' : 'FAIL') . "\n";
echo 'verify trim=' . (password_verify($password, trim($hash)) ? 'PASS' : 'FAIL') . "\n";
?>