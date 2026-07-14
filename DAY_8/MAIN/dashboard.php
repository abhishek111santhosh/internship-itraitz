<?php
require_once 'auth_check.php';
require_login();

$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>EMS Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <nav class="navbar navbar-dark bg-dark px-4 py-2 mb-5">
    <span class="navbar-brand fw-medium fs-5">EMS Dashboard</span>
    <div class="d-flex align-items-center text-light small">
      <span class="me-3">Welcome,
        <?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?> (
        <?php echo strtoupper($_SESSION['role']); ?>)
      </span>
      <a href="logout.php" class="btn btn-outline-danger btn-sm px-3">Logout</a>
    </div>
  </nav>

  <div class="container" style="max-width: 1000px;">
    <?php if ($error): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?php echo htmlspecialchars($error); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?php echo htmlspecialchars($success); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="mb-4">
      <h2 class="fw-bold mb-1">Welcome to your Dashboard</h2>
      <p class="text-muted small">You are logged in with authority level: <strong class="text-dark">
          <?php echo strtoupper($_SESSION['role']); ?>
        </strong></p>
    </div>

    <div class="row g-4 mt-1">
      <?php if ($_SESSION['role'] === 'hr'): ?>
<div class="col-md-12 mt-4">
                    <div class="card border-danger border-opacity-50 shadow-sm rounded-3">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h5 class="card-title text-danger fw-bold mb-1">System Access & Authority Control</h5>
                                <p class="card-text text-muted small mb-0">Manually promote employees to Admin/HR status or revoke administrative dashboard access.</p>
                            </div>
                            <a href="access_control.php" class="btn btn-danger px-4 py-2 small fw-medium mt-3 mt-md-0">Manage Permissions</a>
                        </div>
                    </div>
                </div>
        <div class="col-md-6">
          <div class="card h-100 border-primary border-opacity-50 shadow-sm rounded-3">
            <div class="card-body p-4">
              <h5 class="card-title text-primary fw-bold mb-2">Manage Workers</h5>
              <p class="card-text text-muted small mb-4">View the absolute list of company personnel, onboard fresh
                entries, or eliminate accounts.</p>
              <a href="employees.php" class="btn btn-primary px-3 py-2 small fw-medium">Go to Employee Directory</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card h-100 border-success border-opacity-50 shadow-sm rounded-3">
            <div class="card-body p-4">
              <h5 class="card-title text-success fw-bold mb-2">Personal Scope</h5>
              <p class="card-text text-muted small mb-4">Audit your accurate file records, track designations, and update
                contact credentials securely.</p>
              <a href="edit_profile.php?id=<?php echo $_SESSION['user_id']; ?>"
                class="btn btn-success px-3 py-2 small fw-medium">View My Personal Profile</a>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="col-md-6">
          <div class="card h-100 border-success border-opacity-50 shadow-sm rounded-3">
            <div class="card-body p-4">
              <h5 class="card-title text-success fw-bold mb-2">Personal Scope</h5>
              <p class="card-text text-muted small mb-4">Audit your accurate file records, track designations, and update
                contact credentials securely.</p>
              <a href="edit_profile.php" class="btn btn-success px-3 py-2 small fw-medium">View My Personal Profile</a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>