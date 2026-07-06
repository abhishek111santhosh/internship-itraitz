<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Night Shift Clearance Portal</title>
  <style>
    :root {
      --bg-color: #f8fafc;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
      --primary: #2563eb;
      --primary-hover: #1d4ed8;
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
  </style>
</head>

<body>

  <div class="portal-card">
    <h2>Night Shift Clearance</h2>
    <p>Enter your credentials to verify security access.</p>

    <form method="POST" action="approval.php">
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