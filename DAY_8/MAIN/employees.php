<?php
require_once 'auth_check.php';
require_hr(); // Server-side guard: Blocks Employees automatically

$sql = "SELECT u.id as user_id, u.email, u.role, e.full_name, e.department, e.designation, e.salary, e.total_leaves, e.leavetaken 
        FROM users u 
        INNER JOIN employees e ON u.id = e.user_id 
        WHERE u.role IN ('employee', 'hr') 
        ORDER BY u.role DESC, u.id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Corporate Personnel Matrix Index</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-4 pt-5">
  <?php include 'header.php'; ?>

  <div class="container" style="max-width: 1050px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="dashboard.php" class="btn btn-secondary btn-sm px-3 py-2">← Dashboard</a>
      <h3 class="fw-bold mb-0">Corporate Personnel Matrix Index (HR Exclusive)</h3>
      <div></div>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <a href="add_employee.php" class="btn btn-success fw-medium">+ Register Fresh Profile</a>
    </div>

    <div class="card border-0 shadow-sm">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-dark">
            <tr>
              <th class="ps-4 py-3">ID</th>
              <th>Name</th>
              <th>Role</th>
              <th>Department</th>
              <th>Designation</th>
              <th>Salary</th>
              <th>Leaves Remaining</th>
              <th class="text-center pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td class="ps-4 text-muted">#
                    <?php echo (int) $row['user_id']; ?>
                  </td>
                  <td class="fw-bold text-dark">
                    <?php echo htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td>
                    <span class="badge <?php echo $row['role'] === 'hr' ? 'bg-danger' : 'bg-secondary'; ?> px-2 py-1">
                      <?php echo strtoupper(htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8')); ?>
                    </span>
                  </td>
                  <td class="text-muted small">
                    <?php echo htmlspecialchars($row['department'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td class="text-muted small">
                    <?php echo htmlspecialchars($row['designation'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td class="fw-medium text-success">$
                    <?php echo number_format((float) ($row['salary'] ?? 0), 2); ?>
                  </td>
                  <td>
                    <?php
                    $remaining = ($row['total_leaves'] ?? 22) - ($row['leavetaken'] ?? 0);
                    $badgeColor = $remaining <= 5 ? 'bg-warning text-dark' : 'bg-info text-dark';
                    echo "<span class='badge {$badgeColor} px-2 py-1'>{$remaining} / {$row['total_leaves']}</span>";
                    ?>
                  </td>
                  <td class="text-center pe-4">
                    <a href="edit_profile.php?id=<?php echo $row['user_id']; ?>"
                      class="btn btn-outline-primary btn-sm px-2 me-1">Edit</a>
                    <a href="delete_employee.php?id=<?php echo $row['user_id']; ?>"
                      class="btn btn-outline-danger btn-sm px-2"
                      onclick="return confirm('Eliminate this account?');">Delete</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center py-4 text-muted">No personnel records found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>