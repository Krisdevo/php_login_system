<?php
require_once __DIR__ .'/../config/db.php';

function find_user_by_email($email){ // Cherche dans la BDD l'utilisateur avec l'email tapé dans l'input.
    global  $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt-> execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);   
}

function find_user_by_username($username){ // Cherche dans la BDD l'utilisateur avec le pseudo tapé dans l'input.
    global  $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt-> execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);   

}

function create_user( $username, $email, $password ){ // Fonction qui ajoute l'utilisateur dans la BDD
    global  $pdo;
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (? , ?, ?)");
    return $stmt->execute([$username, $email, $hash]);
}

function login_user($user){ // Démarre une session pour l'utilisateur
    $_SESSION['user_id'] = $user['id'];

}

function user_logged_in() { // Fonction qui retourne l'état de la session de l'utilisateur 
    return isset($_SESSION['user_id']);
}

function current_user() { // Fonction qui permet de stocker les données de l'utilisateur connecter 
    global $pdo;
    if(!user_logged_in()) return null;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function remember_me($user_id){ // Fonction qui créé la clé remember pour les cookies
    global $pdo;
    $selector = bin2hex(random_bytes(6)); // Le selector correspond à l'index du token 
    $validator = bin2hex(random_bytes(32)); // Le validator représente le token 
    $expires = date('Y-m-d H:i:s', time() + 864000); // 10 jours

    $hashed_validator = hash('sha256', $validator);
    $pdo ->prepare("INSERT INTO remember_tokens( user_id, selector, hashed_validator, expires) VALUES (?,?,?,?)") // On insère les données dans remember
        ->execute([$user_id, $selector, $hashed_validator,$expires]);
    setcookie('remember', "$selector:$validator", time() + 86400, "/", "", true, true); // On initialise le cookie avec une date de "péremption"

}

function auto_login(){ // Fonction qui permet de comparer le token de l'utilisateur  et celui stocké dans la BDD 
    global $pdo;
    if(isset($_SESSION["user_id"]) || empty($_COOKIE['remember']))return;

    list($selector, $validator) = explode(':', $_COOKIE['remember']);
    $stmt = $pdo->prepare("SELECT * FROM remember_tokens WHERE selector = ? AND expires >= NOW()");
    $stmt->execute([$selector]);
    $token = $stmt->fetch();

    if($token && hash_equals($token['hashed_validator'], hash('sha256', $validator))){
        $_SESSION['user_id'] = $token['user_id'];
    }
}

?>

