<?php
require_once __DIR__ . '/config.php';

// Guard 1: Verify Authentication
function require_login()
{
  if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please log in to access the portal.";
    header("Location: index.php");
    exit();
  }
}

// Guard 2: Verify HR Authority Level
function require_hr()
{
  require_login();
  if ($_SESSION['role'] !== 'hr') {
    // Block employee and bounce back to dashboard
    $_SESSION['error'] = "Access Denied: You do not have HR authority level.";
    header("Location: dashboard.php");
    exit();
  }
}
?>