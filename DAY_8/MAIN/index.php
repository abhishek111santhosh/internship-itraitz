<?php
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit();
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'] ?? '';

  if ($email && $password) {
    $stmt = $conn->prepare("SELECT u.id, u.email, u.password, u.role, e.full_name FROM users u LEFT JOIN employees e ON u.id = e.user_id WHERE u.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['full_name'] = $user['full_name'] ?? 'User';

      header("Location: dashboard.php");
      exit();
    } else {
      $error = "Invalid email or password.";
    }
  } else {
    $error = "Please fill in all required credentials.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EMS Portal Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .login-card {
      max-width: 380px;
      width: 100%;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100">
  <div class="card login-card border-0 rounded-3 p-4 bg-white">
    <h4 class="text-center fw-bold mb-4">EMS Portal Login</h4>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small border-0 bg-danger bg-opacity-10 text-danger rounded-2 mb-3">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="index.php">
      <div class="mb-3">
        <label class="form-label small text-muted">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="enter email" required autofocus>
      </div>
      <div class="mb-4">
        <label class="form-label small text-muted">Password</label>
        <input type="password" name="password" class="form-control" placeholder="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">Login</button>
    </form>
  </div>
</body>

</html>