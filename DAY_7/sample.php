<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = ''; // XAMPP default is empty
$dbName = 'sample_db';

// 1. Create connection
// 1. Connect to MySQL server (without selecting a database)
$conn = new mysqli($host, $username, $password);
if ($conn->connect_errno) {
  die("Database connection failed: " . $conn->connect_error);
}

// 2. Create the database if it doesn't exist, then select it
// Ensure the database exists (create if missing), then reconnect selecting it
$createDbSql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($createDbSql) === false) {
  die("Failed to create database '$dbName': " . $conn->error);
}
$conn->close();

// Reconnect with the database selected
$conn = new mysqli($host, $username, $password, $dbName);
if ($conn->connect_errno) {
  die("Database connection failed (selecting db): " . $conn->connect_error);
}



// 3. Ensure `users` table exists and seed sample data if empty
$createTableSql = "CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  phone VARCHAR(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if ($conn->query($createTableSql) === false) {
  die("Failed to create users table: " . $conn->error);
}

// Seed a sample row if table is empty
$countRes = $conn->query("SELECT COUNT(*) AS cnt FROM users");
if ($countRes) {
  $cntRow = $countRes->fetch_assoc();
  if (isset($cntRow['cnt']) && $cntRow['cnt'] == 0) {
    $stmt = $conn->prepare("INSERT INTO users (name, phone) VALUES (?, ?)");
    if ($stmt) {
      $stmt->bind_param('ss', $n, $p);
      $n = 'Alice Example';
      $p = 'alice@example.com';
      $stmt->execute();
      $stmt->close();
    }
  }
  $countRes->free();
}

// 4. Execute the query to fetch users
$sql = "SELECT id, name, phone FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User List (MySQLi)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #f4f4f4;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
  </style>
</head>

<body>

  <h2>Users Directory</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <!-- 5. Fetch rows one by one as an associative array -->
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No users found or query failed.</p>
  <?php endif; ?>

</body>

</html>

<?php
// 6. Free result set and close connection
if ($result) {
  $result->free();
}
$conn->close();
?>