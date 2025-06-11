
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion</title>
</head>
<body>
    <h1>Connectez-Vous!</h1>
    <form action="process_login.php" method="post">
        <label for="email"> E-mail</label>
        <input type="email" name="email" id ="email" required> <br>
        <label for="password"> Mot de passe</label>
        <input type="password" name="password" id="password" required><br>
        <div class="checked">
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Se souvenir de moi!</label>
        </div>
        <button type="submit">Me connecter</button>

    </form>    
</body>
</html>