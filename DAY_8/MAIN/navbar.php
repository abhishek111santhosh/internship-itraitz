<?php
// Ensure session is active to read role and email
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$userRole = $_SESSION['role'] ?? 'guest';
$userEmail = $_SESSION['email'] ?? 'User';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<style>
  .navbar-dark .nav-link {
    color: rgba(255, 255, 255, 0.85);
    transition: color 0.2s ease;
  }

  .navbar-dark .nav-link:hover,
  .navbar-dark .nav-link:focus {
    color: #fff;
  }

  .navbar-dark .nav-link.active {
    color: #fff;
    font-weight: 700;
    border-bottom: 2px solid #818cf8;
  }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="dashboard.php">🏢 EMS Portal</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link<?php echo $currentPage === 'dashboard.php' ? ' active' : ''; ?>" href="dashboard.php" <?php echo $currentPage === 'dashboard.php' ? ' aria-current="page"' : ''; ?>>Dashboard</a>
        </li>

        <?php if ($userRole === 'hr'): ?>
          <li class="nav-item">
            <a class="nav-link<?php echo $currentPage === 'employees.php' ? ' active' : ''; ?>" href="employees.php" <?php echo $currentPage === 'employees.php' ? ' aria-current="page"' : ''; ?>>Employee Directory</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $currentPage === 'add_employee.php' ? ' active' : ''; ?>" href="add_employee.php"
              <?php echo $currentPage === 'add_employee.php' ? ' aria-current="page"' : ''; ?>>+ Onboard Staff</a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?php echo $currentPage === 'manage_whitelist.php' ? ' active' : ''; ?>"
              href="manage_whitelist.php" <?php echo $currentPage === 'manage_whitelist.php' ? ' aria-current="page"' : ''; ?>>Whitelist Manager</a>
          </li>
        <?php endif; ?>
      </ul>

      <div class="d-flex align-items-center text-light small">
        <span class="me-3">
          Logged in as: <strong class="text-warning">
            <?php echo htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8'); ?>
          </strong>
          (<span class="text-uppercase">
            <?php echo htmlspecialchars($userRole, ENT_QUOTES, 'UTF-8'); ?>
          </span>)
        </span>
        <a href="edit_profile.php" class="btn btn-outline-light btn-sm me-2">My Profile</a>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
      </div>
    </div>
  </div>
</nav>