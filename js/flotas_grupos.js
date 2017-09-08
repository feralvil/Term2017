/*
Funciones Javascript para flotas_grupos.php
*/
$(function(){
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
    // Botón Atras:
    $("button#botatras").click(function(){
        $("form#formaccion").attr('action', 'flotas_detalle.php');
        $("form#formaccion").submit();
    });
    // Botón Agregar Grupo:
    $("button#botadd").click(function(){
        $("form#formaccion").attr('action', 'grupos_flotaadd.php');
        $("form#formaccion").submit();
    });
    // Botón Eliminar Grupo:
    $("button#botdel").click(function(){
        $("form#formaccion").attr('action', 'grupos_flotadel.php');
        $("form#formaccion").submit();
    });
    // Botón Importar Excel:
    $("button#botexcel").click(function(){
        $("form#formaccion").attr('action', 'flotas_importar.php');
        $("form#formaccion").submit();
    });
});
