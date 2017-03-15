/*
Funciones Javascript para flotas_acceso.php
*/

$(function(){
    // Boton atrás:
    $("button#botatras").click(function(){
        $("form#flotasdetalle").submit();
    });
    //Cambio de idioma - VA:
    $("a#valencia").click(function(){
        // Modificamos la cookie de idioma:
        document.cookie = "idioma=va";
        $("form#formidioma").submit();
    });
    //Cambio de idioma - ES:
    $("a#castellano").click(function(){
        // Modificamos la cookie de idioma:
        document.cookie = "idioma=es";
        $("form#formidioma").submit();
    });
});
