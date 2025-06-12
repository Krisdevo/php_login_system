<?php
require 'db.php';
session_start();

if (isset($_COOKIE['remember_me'])) { // si la cléf "remember_me" est présente
    list($selector, $validator) = explode(':', $_COOKIE['remember_me']); 
    // fabrique une liste a partir du token CRSF
    $stmt = $pdo->prepare("DELETE FROM remember_tokens WHERE selector = ?");
    $stmt->execute([$selector]);

    // changer en negatif la durée de vie de la clef
    setcookie("remember_me", "", time() - 3600, "/");

}

session_unset();
session_destroy();

// redirection vers la page de connection
header("Location: login.php");
exit;
