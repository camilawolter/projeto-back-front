<?php
require_once('config/db.php');
require_once('config/user_functions.php');

// Verifique se o usuário está logado
if (!isset($_SESSION['logado'])) {
  header('Location: /projeto-back-front/index.php?page=login');
  exit();
}

// Obtendo as informações do usuário logado
$userId = $_SESSION['user_id'];
$user = getUserInfo($conexao, $userId);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil - Editar Informações</title>
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/profile.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>

<?php require('includes/navbar.php'); ?>

<body>
  <h1>Editar Perfil</h1>
  <form method="POST" action="controllers/ProfileController.php" enctype="multipart/form-data">
    <?php if (isset($_SESSION['message'])): ?>
      <div class="message">
        <?php echo htmlspecialchars($_SESSION['message']);
        unset($_SESSION['message']); ?>
      </div>
    <?php endif; ?>
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
    <br><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <br><br>

    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password_user']); ?>" required>
    <br><br>

    <div class="drag-drop-area" id="dragDropArea">
      <p>Arraste e solte sua imagem aqui ou clique para selecionar</p>
      <img src="/projeto-back-front/assets/images/<?php echo htmlspecialchars($user['image']); ?>" alt="Foto de Perfil" id="previewImage" class="profile-image">

      <input type="file" id="image" name="image" accept="image/*" style="display: none;">
    </div>
    <br><br>


    <button type="submit" name="update">Atualizar</button>
  </form>
  <script src="/projeto-back-front/assets/js/script.js"></script>
</body>
<?php require('includes/footer.php'); ?>

</html>