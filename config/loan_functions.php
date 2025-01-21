<?php

function insertLoan($conexao, $user_id, $book_id, $loan_date, $return_date, $status)
{
  try {
    // Prepara a query para inserir o empréstimo
    $query = $conexao->prepare("INSERT INTO Loan (user_id, book_id, loan_date, return_date, status_load) VALUES (:user_id, :book_id, :loan_date, :return_date, :status)");

    // Faz o bind dos parâmetros
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $query->bindParam(':loan_date', $loan_date, PDO::PARAM_STR);
    $query->bindParam(':return_date', $return_date, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);

    // Executa a query
    $query->execute();

    // Atualiza a quantidade de livros disponíveis
    $updateQuery = $conexao->prepare("UPDATE Book SET quantity = quantity - 1 WHERE id = :book_id");
    $updateQuery->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $updateQuery->execute();

    return true;
  } catch (PDOException $e) {
    // Exibe a mensagem de erro em caso de falha
    echo 'Error: ' . $e->getMessage();
    return false;
  }
}

// Função para formatar a data no formato dd-mm-yyyy
function formatDate($date)
{
  $dateTime = new DateTime($date); // Cria um objeto DateTime
  return $dateTime->format('d-m-Y'); // Retorna a data no formato dd-mm-yyyy
}

// Função para transformar o status em um valor legível
function formatStatus($status)
{
  switch ($status) {
    case 'pending':
      return 'Pendente';
    case 'approved':
      return 'Reservado';
    case 'returned':
      return 'Devolvido';
    default:
      return $status; // Se o status não for nenhum dos três, retorna o valor original
  }
}

// Função para obter todos os empréstimos
function getAllLoans($conexao)
{
  $query = $conexao->prepare(
    "SELECT Loan.id, Users.name AS user_name, Book.title AS book_title, Loan.loan_date, Loan.return_date, Loan.status_load 
        FROM Loan
        JOIN Users ON Loan.user_id = Users.id
        JOIN Book ON Loan.book_id = Book.id"
  );
  $query->execute();
  $loans = $query->fetchAll(PDO::FETCH_ASSOC);

  // Formatar as datas e os status
  foreach ($loans as &$loan) {
    $loan['loan_date'] = formatDate($loan['loan_date']);
    $loan['return_date'] = formatDate($loan['return_date']);
    $loan['status_load'] = formatStatus($loan['status_load']);
  }

  return $loans;
}

// Função para obter os empréstimos de um usuário específico
function getUserLoans($conexao, $userId)
{
  $query = $conexao->prepare(
    "SELECT Loan.id, Book.title AS book_title, Loan.loan_date, Loan.return_date, Loan.status_load 
        FROM Loan
        JOIN Book ON Loan.book_id = Book.id
        WHERE Loan.user_id = :user_id"
  );
  $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
  $query->execute();

  // Obtém os resultados
  $loans = $query->fetchAll(PDO::FETCH_ASSOC);

  // Formatar as datas e os status
  foreach ($loans as &$loan) {
    $loan['loan_date'] = formatDate($loan['loan_date']);
    $loan['return_date'] = formatDate($loan['return_date']);
    $loan['status_load'] = formatStatus($loan['status_load']);
  }

  return $loans;
}

// Atualizar o status do empréstimo e ajustar a quantidade de livros
function updateLoanStatus($conexao, $loanId, $status)
{
  try {
    // Iniciar transação
    $conexao->beginTransaction();

    // Atualizar o status do empréstimo
    $query = $conexao->prepare("UPDATE Loan SET status_load = :status WHERE id = :loan_id");
    $query->bindParam(':loan_id', $loanId, PDO::PARAM_INT);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();

    // Verificar se o status foi alterado para "devolvido"
    if ($status === 'returned') {
      // Obter o ID do livro associado ao empréstimo
      $bookQuery = $conexao->prepare("SELECT book_id FROM Loan WHERE id = :loan_id");
      $bookQuery->bindParam(':loan_id', $loanId, PDO::PARAM_INT);
      $bookQuery->execute();
      $bookId = $bookQuery->fetchColumn();

      // Incrementar a quantidade do livro
      $updateBookQuery = $conexao->prepare("UPDATE Book SET quantity = quantity + 1 WHERE id = :book_id");
      $updateBookQuery->bindParam(':book_id', $bookId, PDO::PARAM_INT);
      $updateBookQuery->execute();
    }

    // Confirmar a transação
    $conexao->commit();
    return true;
  } catch (PDOException $e) {
    // Reverter a transação em caso de erro
    $conexao->rollBack();
    echo 'Erro: ' . $e->getMessage();
    return false;
  }
}
