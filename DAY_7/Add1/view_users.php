<?php
$conn = new mysqli("localhost", "root", "", "user_db");
$result = $conn->query("SELECT * FROM users");
?>
<table border="1">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Action</th>
  </tr>
  <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td>
        <?php echo $row['name']; ?>
      </td>
      <td>
        <?php echo $row['email']; ?>
      </td>
      <td>
        <?php echo $row['role']; ?>
      </td>
      <td><a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a></td>
    </tr>
  <?php endwhile; ?>
</table>