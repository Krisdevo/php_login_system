<?php
session_start();
session_unset();
session_destroy();

//Suppression cookie Remember

setcookie("remember_token", "", time() - 3600,"/");

header('Location: login.php');
?>