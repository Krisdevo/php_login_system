# Création d'un système d'inscription et de connexion avec PHP

[Screen du formulaire d'inscription](/images/log.png)

## Résumé

Il s'agit d'un petit système d'inscription et de connexion relié à une BDD. L'utilisateur peut s'inscrire, se connecter et se déconnecter.  

## Pré-requis:

Pour installer le projet utilisez la commande git clone.. Installez Xammp et clickez sur le bloc Apache et MySQl. Connectez vous sur PHPmyadmin en tapant sur l'URL de votre navigateur localhost:(votre numéro de port)/phpmyadmin/ Le numéro de port figure dans votre Xammp (cf image ci dessous) si ilnne reconnait pas votre port utilisez le port 3030 et taper dans votre terminal d'editeur de code "php -S localhost:3030

## Description 

### dashboard.php

Ce fichier est simplement notre page d'accueil, une fois que l'utilisateur s'est inscris ou connecter.

On créé un systéme qui ajoutera à l'utilisateur un token unique stockés dans la clé remember_tokens.Ce token servira de sécurité supplémentaire lorsque l'utilisateur essaiera de se connecter car le navigateur récupèrera celui ci pour le comparer lors du processus de connexion.

```
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    list($selector, $validator) = explode(':', $_COOKIE['remember_me']);

    $stmt = $pdo->prepare("SELECT * FROM remember_tokens WHERE selector = ? AND expires >= NOW()");
    $stmt->execute([$selector]);
    $token = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($token && hash_equals($token['hashed_validator'], hash('sha256', $validator))) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$token['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
        }
    }
}
```
Quand nous utilisons des super global pour les afficher sur le site. On utilise la fonction htmlspcialchars() pour éviter toute tentative d'injection html malveillante.

### db.php

Ce fichier permet de créer et gérer la Base de donnée.

### register.php

Ce fichier représente notre formulaire d'inscrpition.

### process_register.php

Ce fichier permet d'instaurer la logique de récupération de donnée d'un formulaire de manière sûre. On impose à l'utilisateur de remplir tout les champs du formulaire, on supprime les espaces inutiles et on vérifie bien que l'adresse mail est conforme à la syntaxe de base.
De plus, on créé une variable qui stockera le mot de passe de l'utilisateur en le hashant.

```
    // Créé une variable qui stocke le mot de passe et le hash avec la fonction password_hash
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

```

La fonction getCode récupère la possible erreur 1049.

```
      catch (PDOException $e) { // récupère l'erreur "1049"
        if ($e->getCode() == 23000) {
            echo "Nom d'utilisateur ou email déjà utilisé !";
        }else{ 
            die("Erreur : " .$e->getMessage());
        }
    }

```



### login.php

Ce fichier représente notre formulaire d'incription

### process_login.php

Ce fichier permet de créer la logique de connexion de notre formulaire. On récupère ce qu'écrit notre utilisateur et on va chercher son profil dans notre Base de donnée avec son adresse mail.
Ensuite, on vérifie son mot de passe avec celui qu'il a écrit avec la fonction password_verify()

```
    // Si le user est valid et si le mot de passe correspond au mdp de l'input
    if($user && password_verify($password, $user["password"])){
        //Créer la session utilisateur 
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    }

```
Ensuite on crée un système de cookie relié à l'input "Se souvenir de moi ".
On crée un token pour stockés les données dans le cookie en toute sécurité avec la fonction bin2hex qui permet de convertir les données binaires en hexadécimales. Le token est unique et sera stockés pendant 30 jours dans les cookies.

```
        if(!empty($_POST['remember_me'])){
            $token = bin2hex(random_bytes(16));
            //Créer une variable qui stocke un token convertit en donnée binaire avec représentations hexadécimale
            setcookie('remember_token', $token, time() + (86400*30),"/", "",true, true);
            //Ajoute dans les Cookie le token  avec une date d'expiration de  30 jours
        }

```


### logout.php

Ce fichier créer le processus de déconnexion de l'utilisateur en détruisant la session existante, tout en supprimant les cookies stockés dans "Se souvenir de moi"

### insertCommand.sql

Ce fichier sert à manipuler notre base de donnée.



