<?php
session_start();
setcookie("remember", "", time() - 3600);
session_unset();
session_destroy();
header("Location: " . "../../login/login.php");
?>