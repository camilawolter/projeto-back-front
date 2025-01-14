<?php
include('config/db.php');
include('config/loan_functions.php'); // Certifique-se de que o arquivo com as funções está incluído

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php?page=login');
  exit();
}

// Obtém o ID do usuário logado
$userId = $_SESSION['user_id'];

// Obtém os empréstimos do usuário
$loans = getUserLoans($conexao, $userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meus Empréstimos</title>
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/loans.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>
<?php require('includes/navbar.php'); ?>

<body>
  <header>
    <h1>Meus Empréstimos</h1>
  </header>
  <main>
    <?php if (!empty($loans)) : ?>
      <table border="1">
        <thead>
          <tr>
            <th>Livro</th>
            <th>Data de Empréstimo</th>
            <th>Data de Retorno</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($loans as $loan) : ?>
            <tr>
              <td><?= htmlspecialchars($loan['book_title']) ?></td>
              <td><?= htmlspecialchars($loan['loan_date']) ?></td>
              <td><?= htmlspecialchars($loan['return_date']) ?></td>
              <td><?= htmlspecialchars($loan['status_load']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div id="no-loans">
        <p>Você ainda não realizou nenhum empréstimo.</p>
      </div>
    <?php endif; ?>
  </main>
</body>
<?php require('includes/footer.php'); ?>

</html>