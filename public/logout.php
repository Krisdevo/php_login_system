<?php

session_start();
session_destroy();
setcookie('remember', '', time() -3600, '/', "", true, true);
header("auth.php");
exit;