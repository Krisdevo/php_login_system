<!-- login.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
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
    <label>Email :</label><br>
    <input type="email" name="email" required><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br>

    <label>
      <input type="checkbox" name="remember_me"> Se souvenir de moi
    </label><br>

    <button type="submit">Se connecter</button>
  </form>
</body>
</html>
