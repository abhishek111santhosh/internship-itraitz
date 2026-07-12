<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = ''; // XAMPP default is empty
$dbName = 'sample_db1';

// 1. Create connection
$conn = new mysqli($host, $username, $password, $dbName);

// 2. Check connection
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}



// 3. Execute the query
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
            <td>
              <?= htmlspecialchars($row['id']) ?>
            </td>
            <td>
              <?= htmlspecialchars($row['name']) ?>
            </td>
            <td>
              <?= htmlspecialchars($row['phone']) ?>
            </td>
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