<?php

$hostname = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "school_db";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
