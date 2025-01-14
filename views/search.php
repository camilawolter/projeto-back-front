<?php
require_once('config/db.php');
require_once('config/book_functions.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php?page=login');
  exit();
}
// Verificar se foi enviado um termo de busca
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';
$books = [];

if (!empty($searchTerm)) {
  // Chamar a função para buscar os livros
  $books = searchBooks($conexao, $searchTerm);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultados da Busca</title>
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/search-book.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>
<?php require('includes/navbar.php'); ?>

<body>
  <h1>Resultados da Busca</h1>
  <div id="books-list">
    <?php if (!empty($books)): ?>
      <?php foreach ($books as $book): ?>
        <div class="book">
          <a href="index.php?page=book_info&id=<?php echo $book['id']; ?>">
            <div>
              <img src="assets/images/<?php echo htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Capa do Livro" />
            </div>
            <h3><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
            <p>Autor: <?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Gênero: <?php echo htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>Status: <?php echo $book['quantity'] > 0 ? 'Disponível' : 'Indisponível'; ?></p>
            </form>
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div id="no-results">
        <p>Nenhum livro encontrado para o termo "<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>".</p>
      </div>
    <?php endif; ?>
  </div>
</body>
<?php require('includes/footer.php'); ?>

</html>