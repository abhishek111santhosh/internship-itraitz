<?php
if (isset($_POST['submit'])) {
  $mysqli = new mysqli("localhost", "root", "", "shop_db");

  if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
  }

  $email = trim($_POST['email'] ?? '');
  $dateOfBirth = trim($_POST['date_of_birth'] ?? '');
  $isSubscribed = isset($_POST['is_subscribed']) ? 1 : 0;

  if ($email === '' || $dateOfBirth === '') {
    echo "Please enter both email and date of birth.";
  } else {
    $stmt = $mysqli->prepare("INSERT INTO users (email, date_of_birth, is_subscribed) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $email, $dateOfBirth, $isSubscribed);

    if ($stmt->execute()) {
      echo "New user added successfully!";
    } else {
      echo "Error: " . $stmt->error;
    }

    $stmt->close();
  }

  $mysqli->close();
}
?>
<!DOCTYPE html>
<html>

<body>
  <h2>Add New User</h2>
  <form method="POST" action="add_user.php">
    Email: <input type="email" name="email" required><br>
    Date of Birth: <input type="date" name="date_of_birth" required><br>
    <label><input type="checkbox" name="is_subscribed" checked> Subscribe</label><br>
    <button type="submit" name="submit">Add User</button>
  </form>
</body>

</html>