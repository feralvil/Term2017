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
    // Validar formulario
    $("form#formacceso").submit(function(e){
        var valido = true;
        var error = '';
        var password = $('input#inputpassword').val();
        var passconf = $('input#inputpassconf').val();
        var longpass = password.length;
        if (password.length < 6){
            error = $('input#errlongpass').val();
            valido = false;
            $('input#inputpassword').focus();
        }
        else{
            if (password != passconf){
                error = $('input#errpassigual').val();
                valido = false;
                $('input#inputpassword').focus();
            }
        }
        if(!valido) {
            alert(error);
            e.preventDefault();
        }
    });
});
