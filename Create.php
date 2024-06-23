<?php
include "db_connect.php";
include "functions.php";

$classes = getClasses($conn);
$errors = []; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $address = trim($_POST["address"]);
  $class_id = (int) $_POST["class_id"];


  if (empty($name)) {
    $errors[] = "Name is required.";
  }


  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  }

  if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== 0) {
    $errors[] = "Error uploading image.";
  }

  if (empty($errors)) {
    $image_error = uploadImage($conn, $_FILES["image"]["name"], $_FILES["image"]["tmp_name"]);
    if ($image_error) {
      $errors[] = $image_error; // Add upload error message to errors
    } else {
      $image = ($image_error === "") ? "" : $image_error; // Set image path or empty string
      
      $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $address, $class_id, $image);
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php"); // Redirect to index.php on success
        exit();
      } else {
        <span class="math-inline">errors\[\] \= "Error creating student\."; // Add database error <0\>to errors
\}
\}
\}
\}
?\>
<\!DOCTYPE html\>
<html lang\="en"\>
<head\>
<meta charset\="UTF\-8"\>
<meta name\="viewport" content\="width\=device\-width, initial\-scale\=1\.0"\></0\>
<title\>School Demo \- Create Student</title\>
<<1\>link rel\="stylesheet" href\="https\://cdn\.jsdelivr\.net/npm/bootstrap@5\.2\.0\-beta1/dist/css/bootstrap\.min\.css" integrity\="sha384\-0evNxOUQFNk//Y81zWjYhDD\+CnthMKwRA1T8BG80jDv4s7JDZnGOX9zN/vLqEXjv"</1\> crossorigin\="anonymous"\>
</head\>
<body\>
<h1\>Create Student</h1\>
<?php if \(</span>errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <p><?= $error ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" class="form-control" value="<?= (isset($_POST['name']) ? $_POST['name'] : '') ?>">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" class="form-control" value="<?= (isset($_POST['email']) ? $_POST['email'] : '') ?>">
    </div>
    <div class="form-group">
      <label for="address">Address:</label>
      <textarea name="address" id="address" class="form-control"><?= (isset($_POST['address']) ? $_POST['address'] : '') ?></textarea>
    </div>
    <div class="form-group">
      <label for="class_id">Class:</label>
      <select name="class_id" id="class_id" class="form-control">
        <?php foreach ($classes as $class_id => $class_name): ?>
          <option value="<?= $class_id ?>"<?= (isset($_POST['class_id
