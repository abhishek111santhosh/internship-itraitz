<?php
require_once 'auth_check.php';
require_hr();

$targetId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Prevent HR from deleting their own active session account
if ($targetId && $targetId !== $_SESSION['user_id']) {
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'employee'");
  $stmt->bind_param("i", $targetId);
  if ($stmt->execute()) {
    $_SESSION['success'] = "Employee record eliminated successfully.";
  }
  $stmt->close();
} else {
  $_SESSION['error'] = "Invalid deletion request or authorization conflict.";
}

header("Location: employees.php");
exit();
?>