<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/csrf.php';
require_once '../includes/functions.php';

$errors = [];
$mode = $_GET['mode'] ?? 'login';
$token = generate_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        $errors[] = "Token CSRF invalide.";
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        //Login 
        if ($_POST['action'] === 'login') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email Invalide";
            }
            if (strlen($password) < 8) {
                $errors[] = "Mot de passe trop court(8 caractères min)";
            }

            if (empty($errors)) {
                $user = find_user_by_email($email);
                if ($user && password_verify($password, $user['password'])) {
                    login_user($user);
                    if (isset($_POST['remember']))
                        remember_me($user['id']);
                    header('Location : dashboard.php');
                    exit;
                } else {
                    $errors[] = "Identifiants incorrects";
                }
            }
        }

        // Register
        elseif ($_POST['action'] === 'register') {
            $username = trim($_POST['username'] ?? '');

            if (!$username || !$email || !$password) {
                $errors[] = "Tout les champs sont obligatoires.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide";
            }

            if (strlen($password) < 8) {
                $errors[] = "le mot de passe doit contenir au moins 8 caractères.";
            }

            if (strlen($username) < 3 || strlen($username) > 50) {
                $errors[] = "Le pseudo doit faire entre 3 et 50 caractères.";
            }

            if (find_user_by_username($username)) {
                $errors[] = "Pseudo déjà utilisé !";
            }

            if (find_user_by_email($email)) {
                $errors[] = "Email déjà utilisé ! ";
            }

            if (empty($errors)) {
                if (create_user($username, $email, $password)) {
                    $user = find_user_by_email($email);
                    login_user($user);
                    header('Location : dashboard.php');
                    exit;
                } else {
                    $errors[] = "Erreur à l'inscription";
                }

            }

        }


    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <?php if ($errors): ?>
        <ul style="color : red;">
            <?php foreach ($errors as $e): ?>
                <li>
                    <?= e($e) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= $token ?>">
        <input type="hidden" name="action" value="<?= $mode ?>">

        <h1><?= $mode === 'register' ? 'inscription' : 'Connexion' ?></h1>

        <?php if ($mode === 'register'): ?>

            <label>Pseudo :</label>
            <input type="text" name="username" placeholder="Pseudo" value="<?= e($_POST['username'] ?? '') ?>">

        <?php endif; ?>

        <label>Email :</label>
        <input type="email" name="email" placeholder="email" value="<?= e($_POST['email'] ?? '') ?>">

        <label>Mot de passe :</label>
        <input type="password" name="password" placeholder="Mot de passe">

        <?php if ($mode === 'login'): ?>
            <label class="checked">
                <input type="checkbox" name="remember"> Se souvenir de moi
            </label>
        <?php endif; ?>

        <button><?= $mode === 'register' ? "S'inscrire" : " Se Connecter" ?></button>

        <p>
            <?php if ($mode === 'register'): ?>
                Déjà inscrit ? <a href="?mode=login" class="sign"> Se Connecter !</a>
            <?php else: ?>
                Vous êtes nouveau ? <a href="?mode=register" class="sign">Je m'inscris!</a>
        <?php endif; ?>
        </p>
    </form>

</body>

</html>