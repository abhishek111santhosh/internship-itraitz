<?php
$conn = new mysqli("localhost", "root", "", "user_db");

if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $role = $conn->real_escape_string($_POST['role']);

  $sql = "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id";
  if ($conn->query($sql) === TRUE) {
    echo "Updated successfully! <a href='view_users.php'>Back to List</a>";
  }
}

$id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>

<form method="POST">
  <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
  Name: <input type="text" name="name" value="<?php echo $user['name']; ?>"><br>
  Email: <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>
  Role:
  <select name="role">
    <option value="user" <?php if ($user['role'] == 'user')
      echo 'selected'; ?>>User</option>
    <option value="admin" <?php if ($user['role'] == 'admin')
      echo 'selected'; ?>>Admin</option>
  </select><br>
  <button type="submit" name="update">Save Changes</button>
</form>