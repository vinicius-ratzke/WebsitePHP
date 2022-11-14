<?php
require_once('../../utils/show_errors.php');
require_once('../../utils/authenticated.php');
require_once('../../database/db_functions.php');

if (!isAuthenticated()) {
    session_unset();
    session_destroy();
    header("Location: " . "../login/login.php");
}

if (isset($_SESSION["remember"]) && $_SESSION["remember"]) {
    setcookie("remember", "true", time() + (3600 * 24 * 7), "/");
}

$conn = connect_database();
$categories_sql = "SELECT category_id, category_name FROM $table_categories;";

$category_query = isset($_GET["category"]) ? "WHERE category_id = " . mysqli_real_escape_string($conn, htmlspecialchars($_GET["category"])) : '';
$posts_sql = "SELECT * FROM $table_posts $category_query;";

$categories_result = mysqli_query($conn, $categories_sql);
$posts_result = mysqli_query($conn, $posts_sql);
disconnect_db($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./blog.css">
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
        crossorigin="anonymous" />
    <script
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js">
    </script>
    <script
        src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
    </script>

    <title>Blog do xxMarceloo</title>
</head>

<body>
    <div class="header">
        <h2 class="titulo">Blog do xxMarceloo</h2>
        <div class="logout">
            <a type="button" href="./actions/logout.php"
                class="btn btn-danger">Logout
                (<?= $_SESSION["user_name"]; ?>)</a>
        </div>
        <?php if ($_SESSION['user_is_admin']): ?>
        <div class="create-post">
            <button type="button"
                onclick="window.location.href='../post/post.php'"
                class="btn btn-success">Criar post</button>
        </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="categories">
            <a href="./blog.php">
                <button type="button" class="btn btn-primary">Todas as categorias</button></a>
            <?php if (mysqli_num_rows($categories_result) > 0): ?>
            <?php while($category = mysqli_fetch_assoc($categories_result)): ?>
            <a href="./blog.php?category=<?= $category["category_id"] ?>">
                <button type="button"
                    class="btn btn-primary"><?= $category["category_name"]; ?></button></a>
            <?php endwhile; ?>
            <?php else: ?>
            Nenhuma categoria.
            <?php endif; ?>
        </div>

        <div class="leftcolumn">
            <?php if (mysqli_num_rows($posts_result) > 0): ?>
            <?php while($post = mysqli_fetch_assoc($posts_result)): ?>
            <div class="card">
                <div class="header-card">
                    <div>
                        <h2><?= $post["post_name"]; ?></h2>
                        <?php
                        $conn = connect_database();
                        $category_sql = "SELECT category_name FROM $table_categories WHERE category_id = '" . $post["category_id"] . "';";
                        $category_result = mysqli_query($conn, $category_sql);
                        disconnect_db($conn);
                        ?>
                        <?php if (mysqli_num_rows($categories_result) > 0): ?>
                        <?php while($post_category = mysqli_fetch_assoc($category_result)): ?>
                        <a
                            href="./blog.php?category=<?= $post["category_id"]; ?>">
                            <button type="button"
                                class="btn btn-outline-primary"><?= $post_category["category_name"]; ?></button></a>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($_SESSION['user_is_admin']): ?>
                    <div class="card-actions">
                        <a href="../post/post.php?id=<?= $post["post_id"]; ?>"
                            type="button" class="btn btn-warning">Editar</a>
                        <a href="./actions/delete.php?id=<?= $post["post_id"]; ?>"
                            type="button"
                            onclick="return confirm('Deletar post?')"
                            class="btn btn-danger"><i
                                class="fas fa-trash"></i></a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="detalhe">
                <h5>Criação do post:
                    <?= date_format(new DateTime($post["post_created_at"]),"d/m/Y H:i:s") ?>
                    (Atualizado pela última vez em:
                    <?= date_format(new DateTime($post["post_edited_at"]),"d/m/Y H:i:s") ?>)
                </h5>
                </div>
                <div class="fakeimg">
                    <img src="<?= '../' . $post["post_image"]; ?>">
                </div>
                <p><?= $post["post_description"]; ?></p>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <div class="d-flex p-3 m-3 justify-content-center"
                style="background-color: #c3c3c3;">
                Nenhum post!
            </div>
            <?php endif; ?>
        </div>

        <div class="rightcolumn">
            <div class="card">
                <h2>Sobre o blog:</h2>
                <img src="../../img/marcelo.png" alt="marcelo abrançando uma arvore">
                <p>Criei esse blog em 2022, me chamo Marcelo Batista, sou expert em jogos e esportes, além de investidor nas horas vagas</p>
            </div>
            <div class="card">
                <h2>Talentos:</h2>
                <img src="../../img/marcelo2.png" alt="4k de views">
                <p>Além de tudo, sou um trap star de sucesso como mostra a imagem acima, além de um baita player de kayle.</p>
            </div>

        </div>
    </div>

    <div class="footer">
        <p>Blog xxMarceloo</p>
        <p>Todos os direitos reservados</p>
    </div>
</body>

</html>