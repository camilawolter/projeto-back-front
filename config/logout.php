<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['user_id'])) {
  // Destroi a sessão e redireciona para o login
  session_destroy();
  header('Location: /projeto-back-front/index.php?page=login');
  exit();
} else {
  // Caso o usuário tente acessar o logout sem estar logado, redireciona para login
  header('Location: /projeto-back-front/index.php?page=login');
  exit();
}
