<?php
// Shared header: ensures session and renders the top navbar + dashboard welcome
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Reuse existing navbar markup
include __DIR__ . '/navbar.php';

// Render any flash messages stored in session and show the dashboard welcome
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);
?>

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

</div>