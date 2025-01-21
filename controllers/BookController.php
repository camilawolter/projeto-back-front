<?php
require_once('../config/db.php');
require_once('../config/book_functions.php');
require_once('../config/book_functions.php');

// Cadastrar livro
if (isset($_POST['addBook'])) {
  $title = $_POST['title'];
  $author = $_POST['author'];
  $genre = $_POST['genre'];
  $description = $_POST['description'];
  $published_date = $_POST['published_date'];
  $quantity = $_POST['quantity'];
  $image = $_FILES['image'];

  // Verifica se a imagem foi enviada e faz o upload
  if ($image['tmp_name']) {
    if (!is_dir('../assets/images/')) {
      mkdir('../assets/images/', 0755, true); // Cria a pasta se necessário
  }
    // Garante que o nome do arquivo da imagem seja seguro para ser salvo
    $imageName = basename($image['name']);
    $imagePath = '../assets/images/' . $imageName;
    move_uploaded_file($image['tmp_name'], $imagePath);  // Envia a imagem para a pasta "assets/images"
  } else {
    // Se não enviar imagem, usa a imagem atual do banco de dados
    $imagePath = null;
  }

  // Dados para a função addBook
  $array = [
    'title' => $title, 
    'author' => $author, 
    'genre' => $genre,  
    'description' => $description,
    'published_date' => $published_date, 
    'quantity' => $quantity, 
    'image' => $imageName
  ];

  $updateSuccess = addBook($conexao, $array);

  if ($updateSuccess) {
    session_start();
    $_SESSION['message'] = 'Livro cadastrado com sucesso!';
    header('Location: /projeto-back-front/index.php?page=admin');
    exit();
  } else {
    echo "Erro ao cadastrar o livro.";
  }
}

// Buscar livros
if (isset($_GET['searchTerm'])) {
  session_start();
  $searchTerm = $_GET['searchTerm'];
  $books = searchBooks($conexao, $searchTerm);

  header('Location: /projeto-back-front/index.php?page=search&searchTerm=' . urlencode($searchTerm));
  exit();
}

// Listar todos os livros
if (isset($_GET['page']) && $_GET['page'] == 'home') {
  session_start();
  $books = allBooks($conexao);

  header('Location: /projeto-back-front/index.php?page=home');
  exit();
}

// Informações detalhadas do livro
if (isset($_GET['id'])) {
  $book_id = $_GET['id'];
  $book = getBookById($conexao, $book_id);

  if (!$book) {
    header('Location: /projeto-back-front/index.php?page=home');
    exit();
  }

  include('views/book_info.php');
}

// Verifica se a requisição é para excluir um livro
if (isset($_POST['deleteBook'])) {
  $book_id = $_POST['book_id'];
  $deleteSuccess = deleteBook($conexao, $book_id);

  session_start();
  if ($deleteSuccess) {
    $_SESSION['message'] = 'Livro excluído com sucesso!';
  } else {
    $_SESSION['message'] = 'Erro ao excluir o livro.';
  }

  header('Location: /projeto-back-front/index.php?page=admin');
  exit();
}
