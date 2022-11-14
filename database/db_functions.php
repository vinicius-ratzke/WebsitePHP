<?php
require_once(dirname(__FILE__) . '/credentials.php');

function connect_server() {
    global $servername, $db_username, $db_password;

    $conn = mysqli_connect($servername, $db_username, $db_password);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

function connect_database() {
    global $servername, $db_username, $db_password, $db_name, $table_users, $table_posts, $table_categories;

    $conn = mysqli_connect($servername, $db_username, $db_password, $db_name);
    
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

function disconnect_db($conn){
    mysqli_close($conn);
}
?>