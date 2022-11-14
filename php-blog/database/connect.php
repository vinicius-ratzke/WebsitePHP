<?php
require_once('./db_functions.php');

$conn = connect_server();


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully to $servername<br>";
?>