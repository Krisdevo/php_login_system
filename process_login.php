<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);   

    //Fabrique la requête, parcoure les utilisateurs et trouve par rapport à l'email
    $stmt = $pdo->prepare("SELECT * FROM users  WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le user est valid et si le mot de passe correspond au mdp de l'input
    if($user && password_verify($password, $user["password"])){
        //Créer la session utilisateur 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Si la super globale n'est pas vide 
        if(!empty($_POST['remember_me'])){
            $token = bin2hex(random_bytes(16));
            //Créer une variable qui stocke un token convertit en donnée binaire avec représentations hexadécimale
            setcookie('remember_token', $token, time() + (86400*30),"/", "",true, true);
            //Ajoute dans les Cookie le token  avec une date d'expiration de  30 jours
        }
        header("Location: dashboard.php");
        exit;
    }else{
        echo "Identifiants invalides !";
    }
}
?>