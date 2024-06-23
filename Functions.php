<?php

function getClasses($conn) {
  $sql = "SELECT class_id, name FROM classes";
  $result = mysqli_query($conn, $sql);
  $classes = [];
  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $classes[$row['class_id']] = $row['name'];
    }
  }
  mysqli_free_result($result);
  return $classes;
}

function getStudentById($conn, $id) {
  $sql = "SELECT s.*, c.name AS class_name
          FROM student s
          INNER JOIN classes c ON s.class_id = c.class_id
          WHERE s.id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $student = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);
  mysqli_free_result($result);
  return $student;
}

function validateImage($filename) {
  $allowed_extensions = ["jpg", "jpeg", "png"];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  return in_array(strtolower($ext), $allowed_extensions);
}

function uploadImage($conn, $filename, $tmp_name) {
  $upload_dir = "uploads/";
  $target_file = $upload_dir . basename($filename);


  $check = getimagesize($tmp_name);
  if ($check === false) {
    return "File is not an image.";
  }


  if ($_FILES["image"]["size"] > 500000) {
    return "Sorry, your file is too large.";
  }


  if (!validateImage($filename)) {
    return "Only JPG, JPEG & PNG files are allowed.";
  }


  if (file_exists($target_file)) {
    return "Sorry, file already exists.";
  }


  $new_filename = uniqid() . "." . pathinfo($filename, PATHINFO_EXTENSION);
  $target_file = $upload_dir . $new_filename;


  if (move_uploaded_file($tmp_name, $target_file)) {
    return $new_filename; 
  } else {
    return "Sorry, there was an error uploading your file.";
  }
}

function createStudent($conn, $data) {
  $name = mysqli_real_escape_string($conn, $data['name']);
  $email = mysqli_real_escape_string($conn, $data['email']);
  $address = mysqli_real_escape_string($conn, $data['address']);
  $class_id = (int) $data['class_id'];

  $image_error = "";
  if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
    $image_error = uploadImage($conn, $_FILES["image"]["name"], $_FILES["image"]["tmp_name"]);
  }

  if ($image_error) {
    return $image_error; // Return error message on upload failure
  }

  $image = ($image_error === "") ? $image_error : $new_filename; // Set image path or empty string

  $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_
