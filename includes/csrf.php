<?php
// csrf.php
function generate_csrf_token() { // fonction qui génère un token qui permet de se protéger des tentatives csrf
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) { // Foncction qui permet de vérifier ce token 
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

