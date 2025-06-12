<?php
session_start();
require 'csrf.php';
require 'db.php';

if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    die("⚠️ Tentative CSRF détectée !");
}


function setRememberMe($user_id, $pdo) {
    $selector = bin2hex(random_bytes(6)); // index de position
    $validator = bin2hex(random_bytes(32)); // contenu du token
    $hashed_validator = hash('sha256', $validator); // token cripté 
    $expires = date('Y-m-d H:i:s', time() + (86400 * 30));

    $stmt = $pdo->prepare("INSERT INTO remember_tokens (user_id, selector, hashed_validator, expires) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $selector, $hashed_validator, $expires]);

    setcookie(
        'remember_me',
        "$selector:$validator",
        time() + (86400 * 30),
        '/',
        '',
        true,
        true
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        if (!empty($_POST['remember_me'])) {
            setRememberMe($user['id'], $pdo);
        }

        header("Location: dashboard.php");
        exit;
    } else {
        echo "Identifiants invalides ❌";
    }
}
