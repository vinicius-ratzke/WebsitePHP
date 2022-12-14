<?php
require_once('./connect_database.php');
require_once('../utils/random_string.php');

$sql = "CREATE TABLE $table_categories (
    category_id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(30) NOT NULL,
    post_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    post_edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
if (mysqli_query($conn, $sql)) {
    echo "Table $table_categories created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br>";

$sql = "INSERT INTO $table_categories (category_name)
VALUES ('Games');";
$sql .= "INSERT INTO $table_categories (category_name)
VALUES ('Esportes');";
$sql .= "INSERT INTO $table_categories (category_name)
VALUES ('Livros');";


if (mysqli_multi_query($conn, $sql)) {
  echo "New records in $table_categories table created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

echo "<br>";

while(mysqli_more_results($conn))
   mysqli_next_result($conn);

$sql = "CREATE TABLE $table_posts (
    post_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_name VARCHAR(100) NOT NULL,
    post_description VARCHAR(5000) NOT NULL,
    post_image VARCHAR(300) NOT NULL,
    post_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    post_edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    category_id int(3) UNSIGNED,
    FOREIGN KEY (category_id) REFERENCES $table_categories(category_id) 
    )";
    
if (mysqli_query($conn, $sql)) {
    echo "Table $table_posts created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br>";

array_map('unlink', array_filter((array) glob("../img/posts/*")));

$image1 = '../img/img_base/got.jpg';
$output1 = '../img/posts/' . generateRandomString(15) . '.jpg';
file_put_contents($output1, file_get_contents($image1));

$image2 = '../img/img_base/narnia.jpg';
$output2 = '../img/posts/' . generateRandomString(15) . '.jpg';
file_put_contents($output2, file_get_contents($image2));

$image3 = '../img/img_base/csgo.jpg';
$output3 = '../img/posts/' . generateRandomString(15) . '.jpg';
file_put_contents($output3, file_get_contents($image3));

$image4 = '../img/img_base/cyberpunk.jpg';
$output4 = '../img/posts/' . generateRandomString(15) . '.jpg';
file_put_contents($output4, file_get_contents($image4));

$image5 = '../img/img_base/brasil.jpeg';
$output5 = '../img/posts/' . generateRandomString(15) . '.jpeg';
file_put_contents($output5, file_get_contents($image5));

$image6 = '../img/img_base/xv.png';
$output6 = '../img/posts/' . generateRandomString(15) . '.png';
file_put_contents($output6, file_get_contents($image6));

$sql = "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('Opini??o sobre Cr??nicas de Gelo e Fogo', 'A Guerra dos Tronos veio parar ?? minha estante h?? mais de ano e meio, mas s?? agora, finalmente, ?? que peguei nele e muito resumidamente o que tenho a dizer ?? que j?? n??o era sem tempo! J?? tinha lido ???Sonho Febril??? de George R. R. Martin, um romance vamp??rico, mas sem d??vida que ???As Cr??nicas de Gelo e Fogo??? s??o um trabalho sublime de qualidade e coer??ncia raras.
Sem d??vida uma obra muito boa e uma saga que promete ser das melhores que j?? li, sen??o das melhores que existem. Muito muito bom!', '$output1', 3);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('Opini??o sobre As Cr??nicas de N??rnia', 'As Cr??nicas de N??rnia se mostrou uma historia muito divertida, n??o se deve ler a titulo de comparar com outras historias fant??sticas, como Tolkien por exemplo. Tenho por Tolkien a m??xima admira????o e o tenho como meu autor favorito, mas isso foi posto de lado ao ler Lewis.
?? um livro infantil, assim como o Hobbit, porem, aparentemente, para um publico bem mais infantil, contem varias ilustra????es e cap??tulos breves com fonte em bom tamanho. Altamente recomendado para todos que querem uma boa divers??o, e ?? v??lido ler toda a saga dos sete livros.', '$output2', 3);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('Recomenda????o: Csgo', 'Counter-Strike ?? uma s??rie de jogos eletr??nicos de tiro em primeira pessoa multiplayer, no qual times de terroristas e contra-terroristas batalham entre si, respectivamente, realizando um ato de terror e prevenindo-os. A s??rie iniciou-se no Windows em 1999 com a primeira vers??o do Counter-Strike.', '$output3', 1);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('Opini??o sobre Cyberpunk 2077', 'Cyberpunk 2077 n??o deveria ter sido lan??ado em 2020. A CD Projekt Red deveria ter, mais uma vez, adiado o lan??amento, para poder trabalhar melhor no polimento do game (preferencialmente, sem for??ar seus funcion??rios a vivenciar jornadas abusivas de trabalho, como foi denunciado). Al??m disso, teria sido de bom tom se, ao longo do per??odo de divulga????o, a desenvolvedora tivesse mostrado aos jogadores como o t??tulo rodaria em plataformas mais antigas, como o pr??prio PS4, por exemplo.', '$output4', 1);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('O Brasil j?? ?? hexa', 'A sele????o treinada por Tite, ap??s dominar as eliminat??rias agora ir?? atr??s do seu sexto t??tulo em Copas do Mundo, com Neymar e Vini jr seremos hexa, podem me cobrar depois.', '$output5', 2);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('O maior time do Brasil', 'O Esporte Clube XV de Novembro, mais conhecido como XV de Piracicaba, ?? uma agremia????o brasileira de esporte da cidade de Piracicaba, interior de S??o Paulo. Foi fundada em 15 de novembro de 1913 e suas cores s??o o preto e o branco.', '$output6', 2)";

if (mysqli_multi_query($conn, $sql)) {
  echo "New records in $table_posts table created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

echo "<br>";

while(mysqli_more_results($conn))
   mysqli_next_result($conn);

$sql = "CREATE TABLE $table_users (
    user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(60) NOT NULL,
    user_email VARCHAR(40) NOT NULL,
    user_password VARCHAR(180) NOT NULL,
    user_is_admin BOOLEAN DEFAULT FALSE,
    post_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    post_edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
if (mysqli_query($conn, $sql)) {
    echo "Table $table_users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br>";

$default_password = '123456';
$hashed_default_password = md5($default_password);
$sql = "INSERT INTO $table_users (user_name, user_email, user_password, user_is_admin)
VALUES ('Admin user', 'admin@gmail.com', '$hashed_default_password', TRUE);";

if (mysqli_multi_query($conn, $sql)) {
  echo "New records in $table_users table created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

disconnect_db($conn);
?>