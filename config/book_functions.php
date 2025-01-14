<?php
// Função para cadastrar um livro
function addBook($conexao, $array)
{
  try {
    $query = $conexao->prepare("INSERT INTO Book (title, author, genre, description, published_date, quantity, image) VALUES (:title, :author, :genre, :description, :published_date, :quantity, :image)");
    $resultado = $query->execute($array);
    return $resultado;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return false;
  }
}

// Função para buscar livros por título, autor ou gênero
function searchBooks($conexao, $searchTerm)
{
  try {
    $query = $conexao->prepare("SELECT * FROM Book WHERE title LIKE ? OR author LIKE ? OR genre LIKE ?");
    $term = '%' . $searchTerm . '%';
    $query->execute([$term, $term, $term]);
    $books = $query->fetchAll(PDO::FETCH_ASSOC);
    return $books;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return [];
  }
}

// Função para buscar todos os livros
function allBooks($conexao)
{
  try {
    $query = $conexao->prepare("SELECT * FROM Book");
    $query->execute();
    $books = $query->fetchAll(PDO::FETCH_ASSOC);
    return $books;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return [];
  }
}

// Função para buscar as informações do livro pelo id
function getBookById($conexao, $book_id)
{
  try {
    $query = $conexao->prepare("SELECT * FROM Book WHERE id = :book_id");
    $query->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $query->execute();
    $bookInfo = $query->fetch(PDO::FETCH_ASSOC);
    return $bookInfo;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return [];
  }
}
