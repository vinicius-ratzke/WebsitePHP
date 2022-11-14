<?php
require_once('../../utils/show_errors.php');
require_once('../../database/db_functions.php');
require_once('../../utils/authenticated.php');
require_once('../../utils/check_form.php');

if (!isAuthenticated()) {
    session_unset();
    session_destroy();
    header("Location: " . "../login/login.php");
} else if (!$_SESSION["user_is_admin"]) {
    header("Location: " . "../blog/blog.php");
}

$id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : NULL;
$text = $id ? 'Editar' : 'Criar';
$title = $text . ' post';

$conn = connect_database();
if ($id) {
    $sql = "SELECT * FROM $table_posts WHERE post_id = " . mysqli_real_escape_string($conn, $id);
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) 
        $post = mysqli_fetch_assoc($result);
        $sql = "SELECT * FROM $table_categories WHERE category_id = " . $post["category_id"];
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) 
            $post_category = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$error) {
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    $category = mysqli_real_escape_string($conn, $category);
    $file = mysqli_real_escape_string($conn, $file);
    $date = date('Y-m-d H:i:s');

    if ($id) {
        $sql = "UPDATE $table_posts SET post_name = '$name', post_description = '$description', post_image = '$file', category_id = '$category', post_created_at = '$created_at', post_edited_at = '$date' WHERE post_id = '$id'";
    } else {
        $sql = "INSERT INTO $table_posts
        (post_name, post_description, post_image, category_id) VALUES
        ('$name', '$description', '$file', $category);";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: " . '../blog/blog.php');
        die();
    }
    else {
        $title_error = mysqli_error($conn);
        $error = true;
    }
}
disconnect_db($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./post.css">
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous"></script>
    <script
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
    </script>
    <script
        src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
    </script>
    <script src="./post.js"></script>

    <title><?= $title ?></title>
</head>

<body>       
    <form id="post-form"
        action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?><?php if ($id) echo '?id=' . $id; ?>"
        enctype="multipart/form-data" method="post">
        <div class="container">
            <h2 class="mb-4"><?= $title ?></h2>
            <input type="hidden" name="post_id" id="post_id"
                value="<?php if (isset($post)) echo $post["post_id"]; ?>">
            <input type="hidden" name="old_file" id="old_file"
                value="<?php if (isset($post)) echo $post["post_image"]; ?>">
            <input type="hidden" name="post_created_at" id="post_created_at"
                value="<?php if (isset($post)) echo $post["post_created_at"]; ?>">

            <div class="form-group">
                <label for="title"><b>Título</b></label>
                <input type="text" placeholder="Insira o título.." name="title"
                    value="<?php if (isset($post)) echo $post["post_name"]; ?>"
                    class="form-control <?php if(!empty($title_error)){echo "has-error";}?>"
                    id="title" required>

                <?php if (!empty($title_error)): ?>
                <span class="help-block"><?php echo $title_error ?></span>
                <?php endIf; ?>
            </div>

            <div class="form-group">
                <label for="description"><b>Descrição:</b></label>
                <input type="text" placeholder="Insira a descrição.."
                    name="description"
                    value="<?php if (isset($post)) echo $post["post_description"]; ?>"
                    class="form-control <?php if(!empty($description_error)){echo "has-error";}?>"
                    id="description" required>

                <?php if (!empty($description_error)): ?>
                <span class="help-block"><?php echo $description_error ?></span>
                <?php endIf; ?>
            </div>

            <div class="form-group">
                <label for="category"><b>Categoria</b></label>
                <input type="text" placeholder="Insira a categoria.." name="category"
                    value="<?php if (isset($post)) echo $post_category["category_name"]; ?>"
                    class="form-control <?php if(!empty($category_error)){echo "has-error";}?>"
                    id="category" required>

                <?php if (!empty($category_error)): ?>
                <span class="help-block"><?php echo $category_error ?></span>
                <?php endIf; ?>
            </div>

            <div class="form-group">
                <label for="file"><b>Imagem</b></label>
                <input type="file" class="form-control" name="file"
                    placeholder="Image"
                    class="form-control <?php if(!empty($file_error)){echo "has-error";}?>"
                    id="file">

                <div class="mt-2">
                    <img src="<?= '../' . $post["post_image"]; ?>"
                        alt="Nenhum arquivo selecionado" class="post-image">
                </div>

                <?php if (!empty($file_error)): ?>
                <span class="help-block"><?php echo $file_error ?></span>
                <?php endIf; ?>
            </div>

            <div id="js-errors"></div>
        </div>

        <div class="container" style="display: flex">
            <button type="button"
                onclick="window.location.href='../blog/blog.php'"
                class="btn btn-danger">Cancelar</button>
            <button type="submit" class="btn btn-primary"><?= $text ?></button>
        </div>
    </form>
    </div>
</body>

</html>