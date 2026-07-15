<?php
require_once 'auth_check.php';
require_login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>EMS Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f5f7fb;
    }

    .dashboard-shell {
      max-width: 1000px;
    }

    .dashboard-hero {
      background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
      color: #fff;
      border: 0;
    }

    .dashboard-hero .card-text,
    .dashboard-hero .text-muted {
      color: rgba(255, 255, 255, 0.85) !important;
    }

    .dashboard-card {
      border: 1px solid #e5e7eb;
      border-left: 4px solid #4f46e5;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 0.75rem 1.5rem rgba(15, 23, 42, 0.08) !important;
    }

    .dashboard-card-title {
      color: #111827;
      font-size: 1.05rem;
    }

    .btn-brand {
      background: #4f46e5;
      border-color: #4f46e5;
      color: #fff;
    }

    .btn-brand:hover {
      background: #4338ca;
      border-color: #4338ca;
      color: #fff;
    }
  </style>
</head>

<body class="bg-light pt-4">
  <?php include 'header.php'; ?>

  <div class="container dashboard-shell">
    <div class="mb-4">
      <h2 class="fw-bold mb-1">Welcome back to your dashboard</h2>
      <p class="text-muted small">You are logged in with authority level: <strong class="text-dark">
          <?php echo strtoupper($_SESSION['role'] ?? 'GUEST'); ?>
        </strong></p>
    </div>
    <div class="row g-4 mt-1">
      <?php if ($_SESSION['role'] === 'hr'): ?>
        <div class="col-md-12 mt-2">
          <div class="card dashboard-hero shadow-sm rounded-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
              <div>
                <h5 class="card-title fw-bold mb-1">System Access & Authority Control</h5>
                <p class="card-text small mb-0">Manually promote employees to Admin/HR status or revoke administrative
                  dashboard access.</p>
              </div>
              <a href="access_control.php"
                class="btn btn-light text-primary px-4 py-2 small fw-medium mt-3 mt-md-0">Manage Permissions</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card h-100 dashboard-card shadow-sm rounded-3">
            <div class="card-body p-4">
              <h5 class="card-title dashboard-card-title fw-bold mb-2">Manage Workers</h5>
              <p class="card-text text-muted small mb-4">View the complete list of company personnel, onboard new team
                members, or remove accounts.</p>
              <a href="employees.php" class="btn btn-brand px-3 py-2 small fw-medium">Go to Employee Directory</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card h-100 dashboard-card shadow-sm rounded-3">
            <div class="card-body p-4">
              <h5 class="card-title dashboard-card-title fw-bold mb-2">Personal Scope</h5>
              <p class="card-text text-muted small mb-4">Review your records, track designations, and update your contact
                details securely.</p>
              <a href="edit_profile.php?id=<?php echo $_SESSION['user_id']; ?>"
                class="btn btn-brand px-3 py-2 small fw-medium">View My Personal Profile</a>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="col-md-6">
          <div class="card h-100 dashboard-card shadow-sm rounded-3">
            <div class="card-body p-4">
              <h5 class="card-title dashboard-card-title fw-bold mb-2">Personal Scope</h5>
              <p class="card-text text-muted small mb-4">Review your records, track designations, and update your contact
                details securely.</p>
              <a href="edit_profile.php" class="btn btn-brand px-3 py-2 small fw-medium">View My Personal Profile</a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include 'footer.php'; ?>