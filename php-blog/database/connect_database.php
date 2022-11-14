<?php
require_once('./db_functions.php');

$conn = connect_database();

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully to $db_name<br>";
?>