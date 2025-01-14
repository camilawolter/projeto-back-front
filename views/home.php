<?php
require_once('config/db.php');
require_once('config/book_functions.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php?page=login');
  exit();
}

if (isset($_GET['page']) && $_GET['page'] == 'home') {
  $books = allBooks($conexao); // Chama a função allBooks para obter todos os livros
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="assets/css/home.css">
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>

<?php require('includes/navbar.php'); ?>
<body>
  <h1>Bem-vindo à BiblioTech</h1>
  <form method="GET" action="controllers/BookController.php">
    <input type="text" name="searchTerm" placeholder="Buscar por título, autor ou gênero">
    <button type="submit">Buscar</button>
  </form>
  <hr>
  <h2>Livros Disponíveis</h2>
  <div id="books-list">
    <?php if (!empty($books)): ?>
      <?php foreach ($books as $book): ?>
        <div class="book-item">
          <a href="index.php?page=book_info&id=<?php echo $book['id']; ?>">
            <div>
              <img src="assets/images/<?php echo htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Capa do Livro" />
            </div>
            <h3><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <p>Autor: <?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></p>
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Nenhum livro disponível no momento.</p>
    <?php endif; ?>
  </div>
</body>
<?php require('includes/footer.php'); ?>

</html>