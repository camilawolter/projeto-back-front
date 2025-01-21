<?php
require_once('../config/db.php');
require_once('../config/user_functions.php');

// Verifique se o usuário está logado
session_start();
if (!isset($_SESSION['logado'])) {
  header('Location: /projeto-back-front/index.php?page=login');
  exit();
}

// Obtendo as informações do usuário logado
$userId = $_SESSION['user_id'];
$user = getUserInfo($conexao, $userId);

// Processando o envio do formulário para atualizar os dados
if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
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
    $imagePath = $user['image'];
  }

  // Atualiza as informações do usuário no banco de dados
  $data = [
    'name' => $name,
    'email' => $email,
    'password' => $password,
    'image' => $imageName // Armazena apenas o nome do arquivo no banco
  ];

  $updateSuccess = updateUser($conexao, $userId, $data);

  // Redireciona ou exibe uma mensagem de sucesso
  if ($updateSuccess) {
    session_start();
    $_SESSION['message'] = "Informações atualizadas com sucesso!";
    header('Location: /projeto-back-front/index.php?page=profile'); // Redireciona de volta para o perfil
    exit();
  } else {
    $_SESSION['message'] = "Erro ao atualizar as informações.";
  }
}

// Delete um perfil de usuário
if (isset($_POST['deleteUser'])) {
  $userId = $_POST['user_id'];
  
  if (deleteUser($conexao, $userId)) {
    $_SESSION['message'] = "Usuário excluído com sucesso!";
  } else {
    $_SESSION['message'] = "Erro ao excluir o usuário.";
  }

  header("Location: /projeto-back-front/index.php?page=admin");
  exit();
}
