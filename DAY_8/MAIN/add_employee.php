<?php
require_once 'auth_check.php';
require_hr();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'] ?? '';
  $name = trim(filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
  $dept = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_SPECIAL_CHARS));
  $desig = trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_SPECIAL_CHARS));

  if ($email && $password && $name) {
    $conn->begin_transaction();
    try {
      // 1. Insert Credentials
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      $role = 'employee';
      $uStmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
      $uStmt->bind_param("sss", $email, $hashed, $role);
      $uStmt->execute();
      $newUserId = $conn->insert_id;
      $uStmt->close();

      // 2. Insert Profile Data
      $eStmt = $conn->prepare("INSERT INTO employees (user_id, full_name, phone, department, designation) VALUES (?, ?, ?, ?, ?)");
      $eStmt->bind_param("issss", $newUserId, $name, $phone, $dept, $desig);
      $eStmt->execute();
      $eStmt->close();

      $conn->commit();
      $_SESSION['success'] = "New employee onboarded successfully!";
      header("Location: employees.php");
      exit();
    } catch (Exception $e) {
      $conn->rollback();
      $error = strpos($e->getMessage(), 'Duplicate entry') !== false
        ? "An account with this email address already exists."
        : "Database transaction failed: " . $e->getMessage();
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
  <title>Onboard New Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
  </style>
</head>

<body class="bg-light py-4">
  <div class="container" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="employees.php" class="btn btn-secondary btn-sm px-3 py-2">← Back to Directory</a>
      <h3 class="fw-bold mb-0">Onboard New Employee</h3>
      <div></div>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm p-4 rounded-3 bg-white">
      <form method="POST" action="add_employee.php">
        <div class="section-title text-primary">System Credentials</div>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label small text-muted">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small text-muted">Temporary Password <span class="text-danger">*</span></label>
            <input type="text" name="password" class="form-control" required>
          </div>
        </div>

        <div class="section-title text-success">Profile Data</div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label small text-muted">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label small text-muted">Phone Number</label>
            <input type="text" name="phone" class="form-control">
          </div>
        </div>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label small text-muted">Department</label>
            <input type="text" name="department" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label small text-muted">Designation</label>
            <input type="text" name="designation" class="form-control">
          </div>
        </div>

        <hr class="text-muted mb-4">
        <button type="submit" class="btn btn-success px-4 py-2 fw-medium">Create Account</button>
      </form>
    </div>
  </div>
</body>

</html>