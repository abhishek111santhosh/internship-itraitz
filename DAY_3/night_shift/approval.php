<?php
declare(strict_types=1);

/**
 * Authorization Engine (approval.php)
 * Processes incoming POST requests and renders the clearance decision.
 */

// 1. Guard Check: If someone tries to type "approval.php" directly into their browser URL,
// kick them back to the login form!
if (!isset($_POST['check_btn'])) {
  header("Location: index.php");
  exit;
}

// 2. Variable Storage & Data Cleaning
// htmlspecialchars prevents XSS attacks; trim removes accidental whitespace
$emp_name = htmlspecialchars(trim((string) $_POST['emp_name']), ENT_QUOTES, 'UTF-8');
$job_role = trim((string) $_POST['job_role']);
$safety_code = trim((string) $_POST['safety_code']);

// 3. Business Logic Evaluation
$isApproved = false;
$statusMessage = "";

// Using strcasecmp so 'Manager', 'manager', and 'MANAGER' are all accepted.
// The safety code remains strictly case-sensitive.
if (strcasecmp($job_role, "Manager") === 0 && $safety_code === "safe2026") {
  $isApproved = true;
  $upperName = strtoupper($emp_name);
  $statusMessage = "Night shift APPROVED for " . $upperName;
} else {
  $isApproved = false;
  $statusMessage = "DENIED. You do not have clearance.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clearance Status - Night Shift</title>
  <style>
    :root {
      --bg-color: #f8fafc;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background-color: var(--bg-color);
      color: var(--text-main);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .status-card {
      background-color: var(--card-bg);
      padding: 32px;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-w: 400px;
      border: 1px solid var(--border-color);
      text-align: center;
    }

    .icon-circle {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px auto;
      font-size: 28px;
      font-weight: bold;
    }

    .icon-success {
      background-color: #dcfce7;
      color: #166534;
      border: 1px solid #bbf7d0;
    }

    .icon-danger {
      background-color: #fee2e2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }

    h2 {
      margin-top: 0;
      margin-bottom: 12px;
      font-size: 1.5rem;
    }

    .message {
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 24px;
      padding: 12px;
      border-radius: 6px;
    }

    .msg-success {
      background-color: #f0fdf4;
      color: #15803d;
      border: 1px solid #dcfce7;
    }

    .msg-danger {
      background-color: #fef2f2;
      color: #b91c1c;
      border: 1px solid #fee2e2;
    }

    .back-btn {
      display: inline-block;
      width: 100%;
      padding: 12px;
      background-color: #f1f5f9;
      color: #334155;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      box-sizing: border-box;
      transition: background-color 0.15s ease;
    }

    .back-btn:hover {
      background-color: #e2e8f0;
    }
  </style>
</head>

<body>

  <div class="status-card">
    <?php if ($isApproved): ?>
      <div class="icon-circle icon-success">✓</div>
      <h2>Access Granted</h2>
      <div class="message msg-success">
        <?php echo $statusMessage; ?>
      </div>
    <?php else: ?>
      <div class="icon-circle icon-danger">✕</div>
      <h2>Access Denied</h2>
      <div class="message msg-danger">
        <?php echo $statusMessage; ?>
      </div>
    <?php endif; ?>

    <a href="index.php" class="back-btn">← Test Another Clearance</a>
  </div>

</body>

</html>