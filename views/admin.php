<?php
require_once('config/db.php');
require_once('config/loan_functions.php');
require_once('config/book_functions.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php?page=login');
  exit();
}

// Verificar se o usuário tem a role 'admin'
if ($_SESSION['role'] !== 'admin') {
  echo "Acesso restrito.";
  exit();
}

if (isset($_POST['updateStatus'])) {
  $loan_id = $_POST['loan_id'];
  $status = $_POST['status'];

  // Chama a função para atualizar o status do empréstimo
  updateLoanStatus($conexao, $loan_id, $status);

  session_start();
  $_SESSION['message'] = "Status do empréstimo feito com sucesso!";
  header('Location: index.php?page=admin');
  exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Administração</title>
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/admin.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>

<body>
  <?php require('includes/navbar.php'); ?>
  <h1>Painel de Administração</h1>

  <div class="container">
    <!-- Abas para alternar entre os conteúdos -->
    <div class="tabs">
      <div class="tab active" data-target="tab-cadastrar-livro">Cadastrar Livro</div>
      <div class="tab" data-target="tab-listar-livros">Listar Livros</div>
      <div class="tab" data-target="tab-emprestimos">Empréstimos</div>
    </div>

    <!-- Conteúdo de cada aba -->
    <div class="tab-content active" id="tab-cadastrar-livro">
      <div class="card">
        <div class="card-header">Cadastrar Novo Livro</div>
        <div class="card-body">
          <!-- Mensagem de feedback -->
          <?php if (isset($_SESSION['message'])): ?>
            <div class="message">
              <?php echo htmlspecialchars($_SESSION['message']);
              unset($_SESSION['message']); ?>
            </div>
          <?php endif; ?>
          <form method="POST" action="controllers/BookController.php" enctype="multipart/form-data" class="form-container" id="bookForm">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Autor:</label>
            <input type="text" id="author" name="author" required>

            <label for="genre">Gênero:</label>
            <input type="text" id="genre" name="genre" required>

            <label for="description">Descrição:</label>
            <input type="text" id="description" name="description" required>

            <label for="published_date">Data de Publicação:</label>
            <input type="date" id="published_date" name="published_date" required>

            <label for="quantity">Quantidade:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="image">Imagem (URL ou caminho):</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" name="addBook">Cadastrar Livro</button>
          </form>
        </div>
      </div>
    </div>

    <div class="tab-content" id="tab-listar-livros">
      <div class="card">
        <div class="card-header">Lista de Livros</div>
        <div class="card-body">
          <table class="table-container">
            <thead>
              <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Gênero</th>
                <th>Data Publicação</th>
                <th>Quantidade</th>
                <th>Deletar</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $books = allBooks($conexao); // Chama a função allBooks para listar todos os livros
              foreach ($books as $book) {
                echo "<tr>";
                echo "<td data-label='ID'>" . htmlspecialchars($book['id']) . "</td>";
                echo "<td data-label='Título'>" . htmlspecialchars($book['title']) . "</td>";
                echo "<td data-label='Autor'>" . htmlspecialchars($book['author']) . "</td>";
                echo "<td data-label='Gênero'>" . htmlspecialchars($book['genre']) . "</td>";
                echo "<td data-label='Data Publicação'>" . htmlspecialchars($book['published_date']) . "</td>";
                echo "<td data-label='Quantidade'>" . htmlspecialchars($book['quantity']) . "</td>";
                echo "<td data-label='Deletar'>
                    <form method='POST' action='controllers/BookController.php' onsubmit='return confirm(\"Tem certeza que deseja excluir este livro?\");'>
                      <input type='hidden' name='book_id' value='" . htmlspecialchars($book['id']) . "'>
                      <button type='submit' name='deleteBook' class='delete-button'>Excluir</button>
                    </form>
                  </td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="tab-content" id="tab-emprestimos">
      <div class="card">
        <div class="card-header">Empréstimos Realizados</div>
        <div class="card-body">
          <table class="table-container">
            <thead>
              <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Data Empréstimo</th>
                <th>Data Devolução</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $loans = getAllLoans($conexao);
              foreach ($loans as $loan) {
                echo "<tr>";
                echo "<td  data-label='ID'>" . htmlspecialchars($loan['id']) . "</td>";
                echo "<td data-label='Usuário'>" . htmlspecialchars($loan['user_name']) . "</td>";
                echo "<td data-label='Livro'>" . htmlspecialchars($loan['book_title']) . "</td>";
                echo "<td data-label='Data Empréstimos'>" . htmlspecialchars($loan['loan_date']) . "</td>";
                echo "<td data-label='Data Devolução'>" . htmlspecialchars($loan['return_date']) . "</td>";
                echo "<td data-label='Status'>" . htmlspecialchars($loan['status_load']) . "</td>";
                echo "<td data-label='Ações'>
                    <form method='POST' style='display:inline;'>
                      <input type='hidden' name='loan_id' value='" . htmlspecialchars($loan['id']) . "'>
                      <select name='status' required>
                        <option value='pending' " . ($loan['status_load'] == 'Pendente' ? 'selected' : '') . ">Pendente</option>
                        <option value='approved' " . ($loan['status_load'] == 'Reservado' ? 'selected' : '') . ">Reservado</option>
                        <option value='returned' " . ($loan['status_load'] == 'Devolvido' ? 'selected' : '') . ">Devolvido</option>
                      </select>
                      <button type='submit' name='updateStatus'>Atualizar Status</button>
                    </form>
                  </td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </div>

  <script>
    // Script para alternar entre as abas
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        const target = tab.getAttribute('data-target');
        contents.forEach(content => {
          content.classList.remove('active');
          if (content.id === target) {
            content.classList.add('active');
          }
        });
      });
    });

    document.getElementById('bookForm').addEventListener('submit', function(event) {
      // Selecionando todos os campos de texto
      const textInputs = document.querySelectorAll('input[type="text"]');
      let isValid = true;

      // Verificando se os campos de texto possuem pelo menos 3 caracteres
      textInputs.forEach(input => {
        if (input.value.length < 3) {
          isValid = false;
          alert('Os campos de texto devem ter pelo menos 3 caracteres.');
        }
      });

      // Se algum campo não for válido, impede o envio do formulário
      if (!isValid) {
        event.preventDefault();
      }
    });
  </script>
</body>

<?php require('includes/footer.php'); ?>

</html>