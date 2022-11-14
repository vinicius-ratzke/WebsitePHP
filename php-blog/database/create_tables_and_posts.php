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
VALUES ('Opinião sobre Crônicas de Gelo e Fogo', 'A Guerra dos Tronos veio parar à minha estante há mais de ano e meio, mas só agora, finalmente, é que peguei nele e muito resumidamente o que tenho a dizer é que já não era sem tempo! Já tinha lido ‘Sonho Febril’ de George R. R. Martin, um romance vampírico, mas sem dúvida que ‘As Crónicas de Gelo e Fogo’ são um trabalho sublime de qualidade e coerência raras.
Sem dúvida uma obra muito boa e uma saga que promete ser das melhores que já li, senão das melhores que existem. Muito muito bom!', '$output1', 3);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('Opinião sobre As Crônicas de Nárnia', 'As Crônicas de Nárnia se mostrou uma historia muito divertida, não se deve ler a titulo de comparar com outras historias fantásticas, como Tolkien por exemplo. Tenho por Tolkien a máxima admiração e o tenho como meu autor favorito, mas isso foi posto de lado ao ler Lewis.
É um livro infantil, assim como o Hobbit, porem, aparentemente, para um publico bem mais infantil, contem varias ilustrações e capítulos breves com fonte em bom tamanho. Altamente recomendado para todos que querem uma boa diversão, e é válido ler toda a saga dos sete livros.', '$output2', 3);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('Recomendação: Csgo', 'Counter-Strike é uma série de jogos eletrônicos de tiro em primeira pessoa multiplayer, no qual times de terroristas e contra-terroristas batalham entre si, respectivamente, realizando um ato de terror e prevenindo-os. A série iniciou-se no Windows em 1999 com a primeira versão do Counter-Strike.', '$output3', 1);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('Opinião sobre Cyberpunk 2077', 'Cyberpunk 2077 não deveria ter sido lançado em 2020. A CD Projekt Red deveria ter, mais uma vez, adiado o lançamento, para poder trabalhar melhor no polimento do game (preferencialmente, sem forçar seus funcionários a vivenciar jornadas abusivas de trabalho, como foi denunciado). Além disso, teria sido de bom tom se, ao longo do período de divulgação, a desenvolvedora tivesse mostrado aos jogadores como o título rodaria em plataformas mais antigas, como o próprio PS4, por exemplo.', '$output4', 1);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('O Brasil já é hexa', 'A seleção treinada por Tite, após dominar as eliminatórias agora irá atrás do seu sexto título em Copas do Mundo, com Neymar e Vini jr seremos hexa, podem me cobrar depois.', '$output5', 2);";
$sql .= "INSERT INTO $table_posts (post_name, post_description, post_image, category_id)
VALUES ('O maior time do Brasil', 'O Esporte Clube XV de Novembro, mais conhecido como XV de Piracicaba, é uma agremiação brasileira de esporte da cidade de Piracicaba, interior de São Paulo. Foi fundada em 15 de novembro de 1913 e suas cores são o preto e o branco.', '$output6', 2)";

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