<?php
require_once('../../../utils/show_errors.php');
require_once('../../../database/db_functions.php');

$conn = connect_database();

$sql = "SELECT post_image FROM $table_posts WHERE post_id = " . mysqli_real_escape_string($conn, htmlspecialchars($_GET["id"]));
$images_result = mysqli_query($conn, $sql);

$sql = "DELETE FROM $table_posts WHERE post_id = " . mysqli_real_escape_string($conn, htmlspecialchars($_GET["id"]));
if (mysqli_query($conn, $sql)) {
    if ($images_result && mysqli_num_rows($images_result) > 0) {
        $post = mysqli_fetch_assoc($images_result);
        unlink('../../' . $post['post_image']);
    }
    header("Location: " . "../blog.php");
} else {
    echo "Erro deletando o post: " . mysqli_error($conn);
}

disconnect_db($conn);
?>