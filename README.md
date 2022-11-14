# WebsitePHP

 Blog em PHP
Este projeto consiste em um blog simples, feito com PHP, HTML, CSS e JavaScript, além de possuir integração com banco de dados MySQL e uso das CDNs do Bootstrap e JQuery.

## Começando
Para começar, faça o clone do repositório git na sua máquina.
Após isso, entre na pasta do projeto, então, entre na pasta `database` e acesse o arquivo `credentials.php`. Após feito isso, preencha as variáveis `$servername`, `$db_username` e `$db_password` com os dados da sua conexão MySQL.

## Estrutura do database
O database é nomeado "xxmarcelo" e possui 3 tabelas: users, categories e posts. A tabela users é responsável por guardar os dados dos usuários do sistema, que são email, nome, senha e se é administrador. A tabela categories armazena os nomes das categorias e por último posts é a tabela das postagens do blog, tendo informações de nome, descrição, imagem e id da categoria do post. Desse modo, a tabela de categorias possui relacionamento 1:N com a tabela de posts. Além disso, todas as tabelas possuem, é claro, id e timestamps.


## Estrutura do repositório
No repositório do projeto existem 4 pastas:
- `database`: Possui todos os scripts para criar o banco de dados.
- `img`: Guarda todas as imagens dos posts criados.
- `pages`: Possui os arquivos das páginas do site, de modo que possui uma subpasta para cada página.
- `utils`: Arquivos de uso geral, como funções úteis a mais de um arquivo.


## Setando banco de dados
Após ter o projeto rodando, abra-o no navegador.
Então, entre na pasta database e clique no arquivo chamado `criatudo.php` (ou apenas adicione `/database/criatudo.php` à url). 

## Estrutura do site
O site desenvolvido possui 5 páginas: Login, Registro, Blog, Criação de posts e Edição de posts.

### Login
Página inicial do site, onde é realizado login. Os scripts de criação do banco cria um usuário administrador para testar a aplicação, que possue a senha "123456":
- admin@gmail.com
O usuário comum pode ser criado através da tela de registro e na sequência já tem acesso ao blog e suas postagens.

Nesta página foram feitas validações nos campos de modo a garantir que os mesmos sejam preenchidos, tais como: validação de email válido, verificação se o usuário realmente existe e caso exista, verificação se a senha está correta.

A página conta, ainda, com uma checkbox "Mantenha conectado", a qual possui a finalidade de manter o usuário logado por um período de tempo maior. Quando se faz login com ela desmarcada, é garantido um token via cookie que dura 1 hora. Quando este cookie expira, é necessário logar novamente. Por outro lado, caso seja feito login com o matenha conectado marcado, esse cookie possui duração de 1 semana. Além disso, toda vez que o usuário entra na plataforma a expiração do cookie é prolongada por mais uma semana.

### Registro
Para se registrar, deve-se preencher os campos: Nome de usuário, Email, Senha e Confirmar senha, de modo que o email seja válido e não utilizado por outro usuário, a senha e sua confirmação sejam iguais e demais campos estejam preenchidos. O botão de mantenha conectado funciona da mesma forma que na página de login.

### Blog
Nesta página temos duas possíveis visualizações:
- Usuário comum, o qual possui a visualização dos posts, categorias e opção de logout
- Usuário admin, o qual consegue acessar os mesmos items que o usuário comum, com a adição dos botões de criar, editar e apagar posts.
Em geral, a página faz a listagens dos posts do banco de dados.
No canto superior esquerdo, no menu de categorias, é possível filtrar os posts por categoria.
No canto superior direito, é possível fazer logout, destruindo a sessão e cookie.
Clicando no botão "Criar post" o usuário é redirecionado para a página de criar posts.
Clicando no botão "Editar" o usuário é redirecionado para a página de edição do respectivo post.

### Criar post (Admin)
Para criar um post, o usuário admin deve informar o título do post, bem como sua descrição e nome de uma categoria existente, além de selecionar uma imagem.
A imagem selecionada será salva dentro da pasta `imgs/posts` com um nome único, devendo ser do tipo jpg, jpeg ou png e não ultrapassando o limite de 1MB.
Ao criar o post, a data de criação e edição do post serão marcadas como a atual.

### Editar post (Admin)
Para editar um post, o usuário admin pode alterar qualquer atributo do mesmo (título, descrição, categoria e imagem). Independentemente do que mudar, a data de edição do post será alterada para a atual. Caso seja selecionada outra imagem, a imagem antiga será apagada e a nova será salva em seu lugar, com outro nome único, devendo ser do tipo jpg, jpeg ou png e não ultrapassando o limite de 1MB.

### Deletar post (Admin)
Na página blog, ao clicar no botão vermelho com ícone de lixeira, aparecerá uma confirmação da deleção do post. Caso o usuário clique em "OK", o post será deletado, caso contrário, nada acontecerá.
Ao deletar o post, o mesmo será apagado do banco de dados, bem como sua imagem será deletada da pasta em que estava.

## Autores
Este projeto foi feito pelos alunos:
- Guilherme Franco Batista 
- Leonardo Vzorek 
- Vinicius Ratzke Servelo
