<?php

session_start();
require_once '../includes/auth.php';
auto_login(); // On compare les tokens

header('Location: dashboard.php'); // Si c'est bon on redirige sur la page d'accueil
exit;
?>