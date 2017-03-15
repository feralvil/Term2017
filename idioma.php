<?php
// Obtenemos el idioma de la cookie de JoomFish
if (isset($_COOKIE['idioma'])){
    $idioma = $_COOKIE['idioma'];
}
else{
    $idioma = 'es';
    setcookie("idioma", $idioma);
}


?>
