<?php
require_once('../config/db.php');
require_once('../config/user_functions.php');

// Login
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $array = array($email, $password);
  $user = loginUser($conexao, $array);

  if ($user) {
    session_start();
    $_SESSION['logado'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    header('Location: /projeto-back-front/index.php?page=home');
    exit();
  } else {
    session_start();
    $_SESSION['message'] = "Login inválido";
    header('Location: /projeto-back-front/index.php?page=login');
  }
}

// Registro
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $array = array($name, $email, $password, $role);
  $newUser = registerUser($conexao, $array);
  if ($newUser) {
    $_SESSION['logado'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    session_start();
    $_SESSION['message'] = "Cadastro feito com sucesso, realize o login.";
    header('location: /projeto-back-front/index.php?page=home');
    exit();
  }
  
}
