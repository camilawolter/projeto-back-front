<?php
// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php?page=login');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contato - Bibliotech</title>
  <link rel="stylesheet" href="assets/css/navbar.css">
  <link rel="stylesheet" href="assets/css/contact.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>

<?php require('includes/navbar.php'); ?>

<body>
  <header>
    <h1>Contato</h1>
  </header>
  <main>
    <section class="contact-form">
      <h2>Envie-nos uma mensagem</h2>
      <form id="contactForm">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" placeholder="Seu nome completo" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="Seu e-mail" required>

        <label for="phone">Telefone:</label>
        <input type="tel" id="phone" name="phone" placeholder="(DDD) 0000-0000" required>

        <label for="subject">Assunto:</label>
        <input type="text" id="subject" name="subject" placeholder="Assunto da mensagem" required>

        <label for="message">Mensagem:</label>
        <textarea id="message" name="message" rows="4" placeholder="Digite sua mensagem" required></textarea>

        <button type="submit">Enviar</button>
      </form>
    </section>
    <section class="saved-data">
      <h2>Mensagem Enviada</h2>
      <div id="displayData">
        <p>Nenhuma mensagem enviada.</p>
      </div>
      <button id="clearDataButton" style="display: none;">Desfazer Mensagem</button>
    </section>
  </main>

  <script src="script.js"></script>
</body>
<?php require('includes/footer.php'); ?>

</html>