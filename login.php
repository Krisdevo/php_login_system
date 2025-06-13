<!-- login.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Connexion</h2>
  <?php
    session_start();
    require 'csrf.php';
    require 'db.php';

    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        die("⚠️ Tentative CSRF détectée !");
    }
  ?>
  <form method="POST" action="process_login.php">
    <label>Email :</label>
    <input type="email" name="email" required>

    <label>Mot de passe :</label>
    <input type="password" name="password" required>

    <label class="checked">
      <input type="checkbox" name="remember_me"> Se souvenir de moi
    </label>

    <button type="submit">Se connecter</button>
    <p> Vous êtes nouveau ? <a href="register.php" class="sign">Je m'inscris!</a></p>
  </form>
</body>
</html>
