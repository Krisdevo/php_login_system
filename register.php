<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link rel="stylesheet" href="style.css"> <!-- au besoin -->
</head>
<body>
  <h2>Créer un compte</h2>

  <!-- Génération du Token CSRF -->
  <?php
  require 'csrf.php';
  $token = generateCsrfToken();
  ?>

  <form id="register-form">
    <label>Pseudo :</label>
    <input type="text" name="username" required>

    <label>Email :</label>
    <input type="email" name="email" required>

    <label>Mot de passe :</label>
    <input type="password" name="password" required>

    <button type="submit">S'inscrire</button>
    <p>Déjà inscrit ? <a href="login.php" class="sign"> Se Connecter !</a></p>
    <div id="message"></div>
  </form>

  <!-- Inclure uniquement ici -->
  <script src="public/js/validateRegister.js" defer></script>
</body>
</html>
