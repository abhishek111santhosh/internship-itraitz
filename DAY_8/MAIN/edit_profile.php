<?php
require_once 'auth_check.php';
require_login();

// 1. Strict Scope Resolution
if ($_SESSION['role'] === 'hr') {
  // HR can view/edit any requested ID, defaulting to their own
  $targetUserId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: $_SESSION['user_id'];
} else {
  // SECURITY OVERRIDE: Employees can ONLY ever target their own session ID
  $targetUserId = $_SESSION['user_id'];
}

$error = '';
$success = '';

// 2. Handle Profile Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim(filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS));
  $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
  $dept = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_SPECIAL_CHARS));
  $desig = trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_SPECIAL_CHARS));

  if (!empty($name)) {
    $updateStmt = $conn->prepare("UPDATE employees SET full_name = ?, phone = ?, department = ?, designation = ? WHERE user_id = ?");
    $updateStmt->bind_param("ssssi", $name, $phone, $dept, $desig, $targetUserId);

    if ($updateStmt->execute()) {
      $success = "Profile record updated successfully!";
      if ($targetUserId === $_SESSION['user_id']) {
        $_SESSION['full_name'] = $name; // Keep session synced
      }
    } else {
      $error = "Failed to update record: " . $conn->error;
    }
    $updateStmt->close();
  } else {
    $error = "Full Name cannot be left blank.";
  }
}

// 3. Fetch Data for Render
$stmt = $conn->prepare("SELECT u.email, u.role, e.full_name, e.phone, e.department, e.designation 
                        FROM users u 
                        INNER JOIN employees e ON u.id = e.user_id 
                        WHERE u.id = ?");
$stmt->bind_param("i", $targetUserId);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$profile) {
  $_SESSION['error'] = "Profile record not found.";
  header("Location: dashboard.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Profile Record Configuration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .readonly-field {
      background-color: #e9ecef;
      border-color: #dee2e6;
      color: #495057;
    }
  </style>

</head>

<body class="bg-light py-4">

  <body class="bg-light py-4 pt-5">
    <?php include 'header.php'; ?>

    <div class="container" style="max-width: 1000px;">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="<?php echo ($_SESSION['role'] === 'hr' && $targetUserId !== $_SESSION['user_id']) ? 'employees.php' : 'dashboard.php'; ?>"
          class="btn btn-secondary btn-sm px-3 py-2">
          ← Back to
          <?php echo ($_SESSION['role'] === 'hr' && $targetUserId !== $_SESSION['user_id']) ? 'Directory' : 'Dashboard'; ?>
        </a>
        <h3 class="fw-bold mb-0">Profile Record Configuration</h3>
        <div></div>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
      <?php if ($success): ?>
        <div class="alert alert-success py-2 small"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

      <div class="card border-0 shadow-sm p-4 rounded-3 bg-white">
        <form method="POST"
          action="edit_profile.php<?php echo ($_SESSION['role'] === 'hr') ? '?id=' . $targetUserId : ''; ?>">

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label small text-muted">Email Context (Immutable)</label>
              <input type="text" class="form-control readonly-field"
                value="<?php echo htmlspecialchars($profile['email'], ENT_QUOTES, 'UTF-8'); ?>" readonly tabindex="-1">
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted">System Role Access</label>
              <input type="text" class="form-control readonly-field text-uppercase"
                value="<?php echo htmlspecialchars($profile['role'], ENT_QUOTES, 'UTF-8'); ?>" readonly tabindex="-1">
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label small text-muted">Full Name</label>
              <input type="text" name="full_name" class="form-control"
                value="<?php echo htmlspecialchars($profile['full_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted">Contact Phone</label>
              <input type="text" name="phone" class="form-control"
                value="<?php echo htmlspecialchars($profile['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label small text-muted">Department</label>
              <input type="text" name="department" class="form-control"
                value="<?php echo htmlspecialchars($profile['department'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label small text-muted">System Designation</label>
              <input type="text" name="designation" class="form-control"
                value="<?php echo htmlspecialchars($profile['designation'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>
          </div>

          <button type="submit" class="btn btn-primary px-3 py-2 fw-medium">Save Profile Changes</button>
        </form>
        <?php include 'footer.php'; ?>