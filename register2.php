<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="public/css/style.css"> <!-- au besoin -->
</head>
<body>
  <h2>Créer un compte</h2>

  <!-- Génération du Token CSRF -->
  <?php
  require 'csrf.php';
  $token = generateCsrfToken();
  ?>

  <form id="register-form">
    <label>Pseudo :</label><br>
    <input type="text" name="username" required><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br>

    <button type="submit">S'inscrire</button>
    <div id="message"></div>
  </form>

  <!-- Inclure uniquement ici -->
  <script src="public/js/validateRegister.js" defer></script>
</body>
</html>
