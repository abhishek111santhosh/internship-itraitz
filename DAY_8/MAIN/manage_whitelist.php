<?php
require_once 'auth_check.php';
require_hr(); // STRICT GUARD: Only HR managers can access this page

$error = '';
$success = '';

// 1. Handle Adding a New Email to the Whitelist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_email'])) {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $dept = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_SPECIAL_CHARS));
  $desig = trim(filter_input(INPUT_POST, 'designation', FILTER_SANITIZE_SPECIAL_CHARS));

  if ($email) {
    $stmt = $conn->prepare("INSERT INTO allocated_workers (email, department_scope, designation_scope) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $dept, $desig);

    if ($stmt->execute()) {
      $success = "Email '$email' has been authorized for registration.";
    } else {
      $error = strpos($conn->error, 'Duplicate entry') !== false
        ? "This email address is already on the authorized whitelist."
        : "Database error: " . $conn->error;
    }
    $stmt->close();
  } else {
    $error = "Please enter a valid email address.";
  }
}

// 2. Handle Removing an Email from the Whitelist
if (isset($_GET['delete_id'])) {
  $deleteId = (int) $_GET['delete_id'];
  $stmt = $conn->prepare("DELETE FROM allocated_workers WHERE id = ?");
  $stmt->bind_param("i", $deleteId);
  if ($stmt->execute()) {
    $success = "Authorized email removed from whitelist.";
  }
  $stmt->close();
}

// 3. Fetch All Currently Authorized Emails
$result = $conn->query("SELECT * FROM allocated_workers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Pre-Allocation Whitelist - EMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4">

  <body class="bg-light py-4 pt-5">
    <?php include 'header.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="dashboard.php" class="btn btn-secondary btn-sm px-3 py-2">← Back to Dashboard</a>
      <h3 class="fw-bold mb-0">Worker Pre-Allocation Whitelist</h3>
      <div></div>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success py-2 small">
        <?php echo htmlspecialchars($success); ?>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm p-4 rounded-3 mb-4 bg-white">
      <h6 class="fw-bold text-primary mb-3">+ Authorize New Worker Email</h6>
      <form method="POST" action="manage_whitelist.php" class="row g-3">
        <input type="hidden" name="add_email" value="1">
        <div class="col-md-4">
          <label class="form-label small text-muted">Worker Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control form-control-sm" placeholder="worker@company.com"
            required>
        </div>
        <div class="col-md-3">
          <label class="form-label small text-muted">Assigned Dept</label>
          <input type="text" name="department" class="form-control form-control-sm" placeholder="e.g. IT">
        </div>
        <div class="col-md-3">
          <label class="form-label small text-muted">Assigned Designation</label>
          <input type="text" name="designation" class="form-control form-control-sm" placeholder="e.g. Analyst">
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary btn-sm w-100 py-2 fw-medium">Authorize</button>
        </div>
      </form>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold text-dark">Currently Authorized Registration Emails</h6>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-dark">
            <tr>
              <th class="ps-4 py-3">ID</th>
              <th>Authorized Email</th>
              <th>Target Department</th>
              <th>Target Designation</th>
              <th>Added On</th>
              <th class="text-end pe-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td class="ps-4 text-muted">#
                    <?php echo (int) $row['id']; ?>
                  </td>
                  <td class="fw-bold text-success">
                    <?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($row['department_scope'] ?? 'General', ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td>
                    <?php echo htmlspecialchars($row['designation_scope'] ?? 'Staff', ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td class="text-muted small">
                    <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                  </td>
                  <td class="text-end pe-4">
                    <a href="manage_whitelist.php?delete_id=<?php echo $row['id']; ?>"
                      class="btn btn-outline-danger btn-sm px-3"
                      onclick="return confirm('Revoke registration authorization for this email?');">Revoke</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">No emails authorized yet. Add one above!</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php include 'footer.php'; ?>