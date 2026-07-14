<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "ems_db";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
  $conn = new mysqli($host, $user, $pass, $db);
  $conn->set_charset("utf8mb4");
} catch (Exception $e) {
  // If database doesn't exist yet, allow setup_db.php to run without crashing
  if (!strpos($_SERVER['SCRIPT_NAME'], 'setup_db.php')) {
    die("<div style='font-family:sans-serif; padding:20px; color:red;'>Database connection failed. If this is your first time, please run <a href='setup_db.php'>setup_db.php</a> first.</div>");
  }
}
?>