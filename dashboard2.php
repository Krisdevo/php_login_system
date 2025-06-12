<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    list($selector, $validator) = explode(':', $_COOKIE['remember_me']);

    $stmt = $pdo->prepare("SELECT * FROM remember_tokens WHERE selector = ? AND expires >= NOW()");
    $stmt->execute([$selector]);
    $token = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($token && hash_equals($token['hashed_validator'], hash('sha256', $validator))) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$token['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
        }
    }
}

// empeche l'acces au dashboard si l'utilisateur n'est pas connecter
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>

<body>
    <h2>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h2>
    <p>Ceci est votre page d'accueil</p>
    <a href="logout.php">Se déconnecter</a>
</body>

</html>