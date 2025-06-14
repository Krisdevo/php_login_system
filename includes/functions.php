<?php
function e($string){ // Permet de nettoyer l'URL de tout code  potentiellement malveillant en altérant son script
    return htmlspecialchars($string, ENT_QUOTES,"UTF-8");
}
?>