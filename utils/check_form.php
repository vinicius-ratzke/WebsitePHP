<?php
require_once(dirname(__FILE__) . '/../database/db_functions.php');
require_once(dirname(__FILE__) . '/random_string.php');

function check_field($text) {
  $text = trim($text);
  $text = stripslashes($text);
  $text = htmlspecialchars($text);
  return $text;
}

$error = false;
$conn = connect_database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (strpos($_SERVER['SCRIPT_NAME'], 'login')) {
    if (empty($_POST["email"])) {
      $email_error = "Email é obrigatório.";
      $error = true;
    }
    else {
      $email = check_field($_POST["email"]);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $invalid_email_error = "Email inválido.";
        $error = true;
      }
    }

    if (empty($_POST["password"])) {
      $password_error = "A senha é obrigatória.";
      $error = true;
    }
    else {
      $password = check_field($_POST["password"]);
    }

    if (!empty($_POST["remember"])) {
      $remember = $_POST["remember"] == 'on';
    }
  } else if (strpos($_SERVER['SCRIPT_NAME'], 'register')) {  // valida registro
    if (empty($_POST["email"])) {
      $email_error = "Email é obrigatório.";
      $error = true;
    }
    else {
      $email = check_field($_POST["email"]);
      $sql = "SELECT user_id FROM $table_users WHERE user_email = '$email';";
      $result = mysqli_query($conn, $sql);
      $user = mysqli_fetch_assoc($result);
      if (isset($user["user_id"])) {
        $email_error = "Email já está sendo utilizado.";
        $error = true;
      } else {        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $invalid_email_error = "Email utilizado é inválido.";
          $error = true;
        }
      }
    }

    if (empty($_POST["username"])) {
      $username_error = "O username é obrigatório.";
      $error = true;
    }
    else {
      $username = check_field($_POST["username"]);
    }

    if (empty($_POST["password"])) {
      $password_error = "A senha é obrigatória.";
      $error = true;
    }
    else {
      $password = check_field($_POST["password"]);

      if (empty($_POST["password-confirmation"])) {
        $password_confirmation_error = "A confirmação de senha é obrigatória.";
        $error = true;
      }
      else {
        $password_confirmation = check_field($_POST["password-confirmation"]);

        if ($password !== $password_confirmation) {
          $password_mismatch_error = "As senhas são diferentes!";
          $error = true;
        }
      }
    }

    if (!empty($_POST["remember"])) {
      $remember = $_POST["remember"] == 'on';
    }
  } else if (strpos($_SERVER['SCRIPT_NAME'], 'post')) {  // valida a edição/criação de posts
    $created_at = $_POST["post_created_at"];
    if (empty($_POST["title"])) {
      $title_error = "Título é obrigatório.";
      $error = true;
    }
    else {
      $name = check_field($_POST["title"]);
    }

    if (empty($_POST["description"])) {
      $description_error = "Descrição ié obrigatória.";
      $error = true;
    }
    else {
      $description = check_field($_POST["description"]);
    }

    if (empty($_POST["category"])) {
      $category_error = "Categoria é obrigatória.";
      $error = true;
    }
    else {
      $category = check_field($_POST["category"]);
      $sql = "SELECT category_id FROM $table_categories WHERE category_name = '$category';";
      $result = mysqli_query($conn, $sql);
      $category = mysqli_fetch_assoc($result);
      if (!isset($category["category_id"])) {
        $category_error = "Categoria não existe.";
        $error = true;
      } else {        
        $category = $category["category_id"];
      }
    }

    if ((empty($_FILES["file"]) || $_FILES["file"]["size"] === 0) && (!isset($_POST["old_file"]) || strlen($_POST["old_file"]) === 0)) {
      $file_error = "A imagem é obrigatória.";
      $error = true;
    }
    else {
      if ((empty($_FILES["file"]) || $_FILES["file"]["size"] === 0) && isset($_POST["old_file"]) && strlen($_POST["old_file"]) > 0) {
        $file = $_POST["old_file"];
      } else {
        if (isset($_POST["old_file"]) && strlen($_POST["old_file"]) > 0)
          unlink('../' . $_POST["old_file"]);
        $target_dir = '../img/posts/';     // salva no db
        $target_dir2 = '../../img/posts/';     // post.php file
        $string = generateRandomString(15);
        $file = $target_dir . $string . basename($_FILES["file"]["name"]);
        $file2 = $target_dir2 . $string . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($file2, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
          if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            $file_error = "A imagem deve ser jpg, jpeg ou png.";
            $error = true;
          } else {
            if ($_FILES["file"]["size"] > 1024*1024) {
              $file_error = "O tamanho da imagem selecionada ultrapassa 1MB!.";
              $error = true;
            } else {
              if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file2)) {
                $file_error = "Não foi possível salvar a imagem.";
                $error = true;
              }
            }
          }
        } else {
          $file_error = "Imagem inválida.";
          $error = true;
        }
      }
    }
  }
}

disconnect_db($conn);
?>