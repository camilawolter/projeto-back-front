<?php
require_once('config/db.php');
require_once('config/book_functions.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php?page=login');
  exit();
}

if (isset($_GET['id'])) {
  $book_id = $_GET['id'];
  $book = getBookById($conexao, $book_id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informações do Livro</title>
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/book_info.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <script>
    // Função para exibir o campo de data de devolução
    function showReturnDate() {
      var returnDateField = document.getElementById('return-date-field');
      var requestButton = document.getElementById('request-loan-btn');
      returnDateField.style.display = 'block';
      requestButton.style.display = 'none';
    }
  </script>
</head>

<?php require('includes/navbar.php'); ?>

<body>
  <h1>Informações do Livro</h1>
  <div class="book-info-container">
    <div class="book-info">
      <div class="book-details">
        <img src="assets/images/<?php echo htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Capa do Livro" class="book-image" />
        <div class="book-text">
          <h3><?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
          <p><strong>Autor:</strong> <?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?></p>
          <p><strong>Gênero:</strong> <?php echo htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8'); ?></p>
          <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($book['description'], ENT_QUOTES, 'UTF-8')); ?></p>
          <p><strong>Status:</strong> <?php echo $book['quantity'] > 0 ? 'Disponível' : 'Indisponível'; ?></p>

          <!-- Mensagem de feedback -->
          <?php
          if (isset($_SESSION['message'])) {
            echo '<p style="color: green;">' . $_SESSION['message'] . '</p>';
            unset($_SESSION['message']); // Remove a mensagem após exibir
          }
          ?>

          <!-- Botão para solicitar empréstimo -->
          <?php if ($book['quantity'] > 0): ?>
            <button type="button" id="request-loan-btn" onclick="showReturnDate()">Solicitar Empréstimo</button>

            <div id="return-date-field" style="display: none;">
              <h4>Escolha a data de devolução</h4>
              <form action="controllers/loanController.php" method="POST">
                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>" />
                <label for="return_date">Data de devolução: </label>
                <input type="date" name="return_date" required />
                <button type="submit" name="loan_book">Solicitar Empréstimo</button>
              </form>
            </div>
          <?php else: ?>
            <p>Este livro está indisponível no momento.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
<?php require('includes/footer.php'); ?>

</html>