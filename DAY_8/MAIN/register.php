<?php
require_once 'config.php';

// If already logged in, send them straight to their dashboard
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 1. Sanitize & Validate Inputs
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm_password'] ?? '';
  $name = trim(filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
  $dept = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_SPECIAL_CHARS));
  $desig = trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_SPECIAL_CHARS));

  if ($email && $password && $confirm && $name) {
    if ($password !== $confirm) {
      $error = "Passwords do not match. Please try again.";
    } elseif (strlen($password) < 6) {
      $error = "Password must be at least 6 characters long for security.";
    } else {
      // --- SECURITY GUARD 1: Check if email is on the Pre-Allocation Whitelist ---
      $whitelistStmt = $conn->prepare("SELECT id, department_scope, designation_scope FROM allocated_workers WHERE email = ?");
      $whitelistStmt->bind_param("s", $email);
      $whitelistStmt->execute();
      $whitelistResult = $whitelistStmt->get_result();
      $allocatedData = $whitelistResult->fetch_assoc();
      $whitelistStmt->close();

      if (!$allocatedData) {
        // BLOCK ACCESS IMMEDIATELY if email is not on the whitelist
        $error = "Access Denied: Your email address ($email) has not been authorized by an HR Administrator.";
      } else {
        // --- SECURITY GUARD 2: Check if an account with this email already exists ---
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
          $error = "An account with this email address is already registered.";
        } else {
          // Automatically use the pre-allocated department & designation if the user left them blank
          $finalDept = !empty($dept) ? $dept : ($allocatedData['department_scope'] ?? 'General');
          $finalDesig = !empty($desig) ? $desig : ($allocatedData['designation_scope'] ?? 'Staff');

          // Execute Database Transaction
          $conn->begin_transaction();
          try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $role = 'employee'; // Force all self-registrations to standard employee role

            // Insert into users table
            $uStmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $uStmt->bind_param("sss", $email, $hashed, $role);
            $uStmt->execute();
            $newUserId = $conn->insert_id;
            $uStmt->close();

            // Insert into employees profile table
            $eStmt = $conn->prepare("INSERT INTO employees (user_id, full_name, phone, department, designation) VALUES (?, ?, ?, ?, ?)");
            $eStmt->bind_param("issss", $newUserId, $name, $phone, $finalDept, $finalDesig);
            $eStmt->execute();
            $eStmt->close();

            $conn->commit();
            $success = "Registration successful! Your allocated account is now active.";
          } catch (Exception $e) {
            $conn->rollback();
            $error = "System error during registration: " . $e->getMessage();
          }
        }
        $checkStmt->close();
      }
    }
  } else {
    $error = "Please fill in all mandatory fields marked with *.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Portal Registration - EMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .reg-card {
      max-width: 650px;
      width: 100%;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .section-title {
      font-size: 0.95rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center py-5" style="min-height: 100vh;">
  <div class="card reg-card border-0 rounded-3 p-4 p-sm-5 bg-white">
    <div class="text-center mb-4">
      <h4 class="fw-bold mb-1">Employee Portal Registration</h4>
      <p class="text-muted small">Create your account using your HR-authorized email address</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small border-0 bg-danger bg-opacity-10 text-danger rounded-2 mb-4">
        <strong>🚫 Registration Blocked:</strong>
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success py-3 text-center border-0 bg-success bg-opacity-10 text-success rounded-2 mb-4">
        <strong>✔
          <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
        </strong><br>
        <a href="index.php" class="btn btn-sm btn-success mt-3 px-4 fw-medium">Proceed to Login</a>
      </div>
    <?php else: ?>

      <form method="POST" action="register.php" autocomplete="off">
        <div class="section-title text-primary mb-3">1. Account Credentials</div>
        <div class="row g-3 mb-3">
          <div class="col-12">
            <label class="form-label small text-muted">Authorized Work Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="name@company.com" required autofocus
              autocomplete="off">
            <div class="form-text" style="font-size: 0.75rem;">You must use the exact email address authorized by your HR
              Administrator.</div>
          </div>
          <div class="col-sm-6">
            <label class="form-label small text-muted">Create Password <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required
              minlength="6" autocomplete="new-password">
          </div>
          <div class="col-sm-6">
            <label class="form-label small text-muted">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required
              minlength="6" autocomplete="new-password">
          </div>
        </div>

        <hr class="text-muted my-4">

        <div class="section-title text-success mb-3">2. Personal Profile Data</div>
        <div class="row g-3 mb-3">
          <div class="col-sm-6">
            <label class="form-label small text-muted">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
          </div>
          <div class="col-sm-6">
            <label class="form-label small text-muted">Contact Phone</label>
            <input type="text" name="phone" class="form-control" placeholder="+91 9876543210">
          </div>
          <div class="col-sm-6">
            <label class="form-label small text-muted">Department</label>
            <input type="text" name="department" class="form-control" placeholder="Optional (Defaults to HR assignment)">
          </div>
          <div class="col-sm-6">
            <label class="form-label small text-muted">Designation</label>
            <input type="text" name="designation" class="form-control" placeholder="Optional (Defaults to HR assignment)">
          </div>
        </div>

        <div class="d-grid mt-4 pt-2">
          <button type="submit" class="btn btn-primary py-2 fw-medium">Verify & Register Account</button>
        </div>
      </form>

    <?php endif; ?>

    <div class="text-center mt-4 pt-3 border-top">
      <span class="text-muted small">Already have an active account?</span>
      <a href="index.php" class="text-decoration-none small fw-bold ms-1">Sign In Here</a>
    </div>
  </div>
</body>

</html>