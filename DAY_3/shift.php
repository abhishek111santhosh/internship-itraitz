<?php
/**
 *  Shift Clearance System
 * Self-contained PHP form processing & business logic implementation.
 */

// Initialize feedback variable
$feedback = "";

// 2. PHP Guard Check: Verify the form submit button was pressed before executing logic
if (isset($_POST['check_btn'])) {

  // 3. Variable Storage: Capture form data from $_POST array
  // We apply trim() to remove unintended whitespace and htmlspecialchars() for security against XSS
  $emp_name = htmlspecialchars(trim($_POST['emp_name']), ENT_QUOTES, 'UTF-8');
  $job_role = trim($_POST['job_role']);
  $safety_code = trim($_POST['safety_code']);

  // 4. Business Logic Implementation:
  // Check role and safety code using equality (==) and logical AND (&&)
  if ($job_role == "Manager" && $safety_code == "safe2026") {
    // Success condition: Concatenate and output approval
    $feedback = '<div class="alert alert-success"> Shift APPROVED for ' . $emp_name . '</div>';
  } else {
    // Failure condition: Output denial
    $feedback = '<div class="alert alert-danger">DENIED!!. You do not have clearance.</div>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Shift Clearance Portal</title>
  <style>
    :root {
      --bg-color: #c1d1e1;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border-color: #0c0c0c;
      --primary: #2563eb;
      --primary-hover: #19a6c3;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background-color: var(--bg-color);
      color: var(--text-main);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }

    .portal-card {
      background-color: var(--card-bg);
      padding: 32px;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-w: 400px;
      border: 1px solid var(--border-color);
    }

    .portal-card h2 {
      margin-top: 0;
      margin-bottom: 8px;
      font-size: 1.5rem;
    }

    .portal-card p {
      color: var(--text-muted);
      font-size: 0.875rem;
      margin-top: 0;
      margin-bottom: 24px;
    }

    .form-group {
      margin-bottom: 16px;
    }

    label {
      display: block;
      font-size: 0.875rem;
      font-weight: 600;
      margin-bottom: 6px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 0.95rem;
      box-sizing: border-box;
      transition: border-color 0.15s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.15s ease;
      margin-top: 8px;
    }

    button:hover {
      background-color: var(--primary-hover);
    }

    .alert {
      padding: 12px 16px;
      border-radius: 6px;
      font-size: 0.875rem;
      font-weight: 500;
      margin-bottom: 20px;
    }

    .alert-success {
      background-color: #dcfce7;
      color: #166534;
      border: 1px solid #bbf7d0;
    }

    .alert-danger {
      background-color: #fee2e2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }
  </style>
</head>

<body>

  <div class="portal-card">
    <h2> Shift Clearance Portal</h2>
    <p>Enter your credentials to verify security access.</p>

    <?php
    if (!empty($feedback)) {
      echo $feedback;
    }
    ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="emp_name">Employee Name</label>
        <input type="text" id="emp_name" name="emp_name" placeholder="Jane Doe" required autocomplete="off">
      </div>

      <div class="form-group">
        <label for="job_role">Job Role</label>
        <input type="text" id="job_role" name="job_role" placeholder="e.g. Manager" required autocomplete="off">
      </div>

      <div class="form-group">
        <label for="safety_code">Safety Code</label>
        <input type="password" id="safety_code" name="safety_code" placeholder="••••••••" required>
      </div>

      <button type="submit" name="check_btn">Verify Clearance</button>
    </form>
  </div>

</body>

</html>