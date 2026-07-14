<?php
require_once 'auth_check.php';
require_hr(); // Only HR managers can access this script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $targetUserId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
  $newRole = $_POST['role'] ?? '';

  // Validate role input against allowed database ENUM values
  if ($targetUserId && in_array($newRole, ['hr', 'employee'])) {

    // SAFETY GUARDRAIL: Prevent HR from changing their own active role!
    if ($targetUserId === $_SESSION['user_id']) {
      $_SESSION['error'] = "Security Alert: You cannot modify or revoke your own HR authority level while logged in.";
    } else {
      $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
      $stmt->bind_param("si", $newRole, $targetUserId);

      if ($stmt->execute()) {
        $_SESSION['success'] = "User authority level successfully updated to: " . strtoupper($newRole);
      } else {
        $_SESSION['error'] = "Database error: Could not update authority level.";
      }
      $stmt->close();
    }
  } else {
    $_SESSION['error'] = "Invalid role modification request.";
  }
}

header("Location: access_control.php");
exit();
?>