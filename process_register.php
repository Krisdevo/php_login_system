<?php
require 'db.php';

// Si le formulaire est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); // Récupère la super global et on cherche la clé "username"
    $email = trim($_POST['email']); // Récupère la super global et on cherche la clé "email"
    $password = trim($_POST['password']); // Récupère la super global et on cherche la clé "password"

    // Vérifie si la clé est un type d'email valide.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Email invalide.');
    }

    if (strlen($password) < 6) {
        die('Mot de passe trop (6caractères min)');
    }
    // Créé une variable qui stocke le mot de passe et le hash avec la fonction password_hash
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // créé une variable pour injections de requêtes SQL
    $stmt = $pdo->prepare("INSERT INTO users (username,email, password) VALUES(?, ?, ?)");

    try { //Essaye d'éxécuter la requête
        $stmt ->execute([$username, $email, $passwordHash]);
        echo"Inscritpion réussie vous pouvez vous <a href='login.php'>Connecter</a>" ;

    } catch (PDOException $e) { // récupère l'erreur "1049"
        if ($e->getCode() == 23000) {
            echo "Nom d'utilisateur ou email déjà utilisé !";
        }else{ 
            die("Erreur : " .$e->getMessage());
        }
    }
}