<?php
session_start();
function isAuthenticated() {
    return isset($_SESSION["user_id"]) && isset($_COOKIE["remember"]);
}
?>