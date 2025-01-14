<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - BiblioTech</title>
  <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
  <div class="container">
    <!-- Lado esquerdo com imagem e texto -->
    <div class="image-container">
      <div class="welcome-text">
        <h1>Crie sua conta na BiblioTech</h1>
        <p>Descubra um mundo de conhecimento. Cadastre-se para acessar milhares de livros e materiais exclusivos.</p>
      </div>
    </div>

    <!-- Lado direito com o formulário -->
    <div class="form-container">
      <form method="POST" action="controllers/AuthController.php">
        <h2>Cadastro</h2>
        <input type="text" name="name" placeholder="Nome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Senha" required>
        <select name="role" id="role" required>
          <option value="">Selecione</option>
          <option value="admin">Bibliotecário</option>
          <option value="user">Usuário Comum</option>
        </select>
        <button type="submit" name="register">Cadastrar</button>
        <p>Já tem uma conta? <a href="index.php?page=login">Faça login</a></p>
      </form>
    </div>
  </div>
</body>

</html>