<?php
include "db_connect.php";
include "functions.php";

$students = [];
$sql = "SELECT s.*, c.name AS class_name
        FROM student s
        INNER JOIN classes c ON s.class_id = c.class_id";
$result = mysqli_query($conn, $sql);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
  }
}
mysqli_free_result($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>School Demo - Students</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" integrity="sha384-0evNxOUQFNk//Y81zWjYhDD+CnthMKwRA1T8BG80jDv4s7JDZnGOX9zN/vLqEXjv" crossorigin="anonymous">
</head>
<body>
  <h1>Students</h1>
  <a href="create.php" class="btn btn-primary mb-3">Create Student</a> 
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Class</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $student): ?>
      <tr>
        <td><?= $student['name'] ?></td>
        <td><?= $student['email'] ?></td>
        <td><?= $student['created_at'] ?></td>
        <td><?= $student['class_name'] ?></td>
        <td><img src="<?= ($student['image'] ? "uploads/" . $student['image'] : "default.png") ?>" alt="<?= $student['name'] ?>" width="50" height="50"></td> <td>
          <a href="view.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-info">View</a>
          <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
