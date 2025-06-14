<?php

session_start();
session_destroy();
setcookie('remember', '', time() -3600, '/', "", true, true); // Supprime les cookies 
header("auth.php");
exit;