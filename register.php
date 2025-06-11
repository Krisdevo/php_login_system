<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscrivez-Vous!</h1>
    <form action="process_register.php" method="post">
        <label for="username">Votre nom</label>
        <input type="text" name="username" id="username" required><br>
        <label for="email">Votre E-mail</label>
        <input type="email" name="email" id ="email" required> <br>
        <label for="password">Choisissez un mot de passe</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">S'inscrire!</button>
    </form>    
</body>
</html>