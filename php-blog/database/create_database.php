<?php
require_once('./connect.php');

$sql = "DROP DATABASE IF EXISTS $db_name";
if (mysqli_query($conn, $sql)) {
  echo "Database dropped successfully";
} else {
  echo "Error dropping database: " . mysqli_error($conn);
}

echo "<br>";

$sql = "CREATE DATABASE $db_name";
if (mysqli_query($conn, $sql)) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . mysqli_error($conn);
}

echo "<br>";
echo "<br>";

disconnect_db($conn);
?>