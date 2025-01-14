<?php

// Função para verificar login
function loginUser($conexao, $array)
{
  try {
    $query = $conexao->prepare("select * from users where email=? and password_user=?");
    if ($query->execute($array)) {
      $pessoa = $query->fetch(); //coloca os dados num array $pessoa
      if ($pessoa) {
        return $pessoa;
      } else {
        return false;
      }
    } else {
      return false;
    }
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

// Função para registrar um novo usuário
function registerUser($conexao, $array)
{
  try {
    $query = $conexao->prepare("insert into users (name, email, password_user, role) values (?, ?, ?, ?)");

    $resultado = $query->execute($array);

    return $resultado;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

// Função para obter informações do usuário logado
function getUserInfo($conexao, $userId)
{
  try {
    $query = $conexao->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$userId]);
    $user = $query->fetch();
    return $user;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }
}

// Função para atualizar as informações do usuário
function updateUser($conexao, $userId, $data)
{
  try {
    // Prepara a consulta SQL para atualizar as informações
    $query = $conexao->prepare("UPDATE users SET name = ?, email = ?, password_user = ?, image = ? WHERE id = ?");
    $result = $query->execute([
      $data['name'],
      $data['email'],
      $data['password'],
      $data['image'],
      $userId
    ]);

    return $result;
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    return false;
  }
}
