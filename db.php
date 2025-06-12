<?php
// db.php
$host = '127.0.1.5';
$dbname = 'phpLogin'; // votre BDD
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}
