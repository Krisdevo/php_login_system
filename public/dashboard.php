<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/functions.php';

auto_login();
if(user_logged_in()){
    header('Location : auth.php');
    exit;
}

$user = current_user();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h2>Bienvenue, <?= e($user['username']) ?> 👋</h2>
    <p>Ceci est votre page d'accueil</p>
    <a href="logout.php">Se déconnecter</a>
</body>

</html>