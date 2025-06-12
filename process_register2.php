<?php
session_start();

require 'db.php';
require 'csrf.php';

// système de protection CRSF
if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    die("! Tentative CSRF détectée !");
}

// si le formulaire est te type "POST"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']); 
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // vérifier si la cléf est un type d'email valide
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Email invalide.');
    }

    // vérifie si le mot de passe est trop petit
    if (strlen($password < 6)) {
        die('Mot de passe trop court (6 caractères min).');
    }
    // créer une variable qui stock le mot de passe et le hash avec la fonction 
    // "password_hash"
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // créer une variable pour injection de requettes SQL
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    try {
        
    $stmt->execute([$username, $email, $passwordHash]);
      
    } catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo " Cet utilisateur ou email existe déjà.";
        } else {
            error_log($e->getMessage());
            echo "❌ Une erreur est survenue, réessayez plus tard.";
        }
        
    }
   
}





























