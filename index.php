<?php
session_start();
include('config/db.php');

// Definir a página padrão
$page = isset($_GET['page']) ? $_GET['page'] : 'login'; // Definindo a página como "home" caso não tenha sido especificada

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user_id']) && $page !== 'login' && $page !== 'register') {
  // Se o usuário não estiver logado e tentar acessar páginas protegidas, redireciona para a página de login
  header('Location: index.php?page=login');
  exit();
}

// Redirecionar para página de admin se for admin
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin' && $page === 'home') {
  // Se o usuário for um admin, redireciona para a página administrativa
  header('Location: index.php?page=admin');
  exit();
}

// Lógica de exibição do conteúdo
switch ($page) {
  case 'login':
    include('views/login.php');
    break;

  case 'register':
    include('views/register.php');
    break;

  case 'home':
    include('views/home.php');
    break;

  case 'search':
    include('views/search.php');
    break;
  
  case 'book_info':
    include('views/book_info.php');
    break;

  case 'profile':
    include('views/profile.php');
    break;

  case 'contact':
    include('views/contact.php');
    break;

  case 'admin':
    if ($_SESSION['role'] !== 'admin') {
      echo "Acesso restrito.";
      exit();
    }
    include('views/admin.php');
    break;
  
  case 'loans':
    include('views/loans.php');
    break;    

  case 'logout':
    include('config/logout.php');
    break;

  default:
    echo "Página não encontrada!";
    break;
}
