<?php
require_once 'auth_check.php';
require_hr(); // Guarded: Strictly HR only

// Fetch all registered users and their profile names
$sql = "SELECT u.id, u.email, u.role, u.created_at, e.full_name, e.department 
        FROM users u 
        LEFT JOIN employees e ON u.id = e.user_id 
        ORDER BY u.role DESC, u.id ASC";
$result = $conn->query($sql);

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Access Control - EMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4">
  <div class="container" style="max-width: 1000px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="dashboard.php" class="btn btn-secondary btn-sm px-3 py-2">← Back to Dashboard</a>
      <h3 class="fw-bold mb-0">System Authority & Access Control</h3>
      <div></div>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success py-2 small">
        <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3">
      <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold text-dark">Manage User Permissions</h6>
        <p class="text-muted small mb-0">Grant or revoke Admin/HR dashboard privileges for company personnel.</p>
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-dark">
            <tr>
              <th class="ps-4 py-3">ID</th>
              <th>User Name</th>
              <th>Email Address</th>
              <th>Department</th>
              <th>Current Authority</th>
              <th class="text-end pe-4">Manual Control Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td class="ps-4 text-muted">#
                    <?php echo (int) $row['id']; ?>
                  </td>
                  <td class="fw-bold text-dark">
                    <?php echo htmlspecialchars($row['full_name'] ?? 'Unprofiled User', ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td class="text-muted">
                    <?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td class="text-muted">
                    <?php echo htmlspecialchars($row['department'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td>
                    <span class="badge <?php echo $row['role'] === 'hr' ? 'bg-danger' : 'bg-secondary'; ?> px-3 py-2">
                      <?php echo strtoupper(htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8')); ?>
                    </span>
                  </td>
                  <td class="text-end pe-4">
                    <?php if ($row['id'] === $_SESSION['user_id']): ?>
                      <span class="text-muted small fst-italic">Current Active Session</span>
                    <?php elseif ($row['role'] === 'employee'): ?>
                      <form method="POST" action="update_role.php" class="d-inline"
                        onsubmit="return confirm('Grant full HR/Admin privileges to this user?');">
                        <input type="hidden" name="user_id" value="<?php echo (int) $row['id']; ?>">
                        <input type="hidden" name="role" value="hr">
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-medium">
                          + Promote to HR
                        </button>
                      </form>
                    <?php else: ?>
                      <form method="POST" action="update_role.php" class="d-inline"
                        onsubmit="return confirm('Revoke HR privileges? They will be demoted to standard Employee.');">
                        <input type="hidden" name="user_id" value="<?php echo (int) $row['id']; ?>">
                        <input type="hidden" name="role" value="employee">
                        <button type="submit" class="btn btn-outline-secondary btn-sm px-3 fw-medium">
                          Revoke Access
                        </button>
                      </form>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">No accounts found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>