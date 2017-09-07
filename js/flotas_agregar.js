/*
Funciones Javascript para flotas_agregar.php
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
    // Validar formulario
    $("form#formagregar").submit(function(e){
        var valido = true;
        var error = '';
        var flota = $('input#inputflota').val();
        var login = $('input#inputlogin').val();
        var password = $('input#inputpassword').val();
        var passconf = $('input#inputpassconf').val();
        var longpass = password.length;
        if (flota.length < 6){
            error = $('input#errlongflota').val();
            valido = false;
            $('input#inputflota').focus();
        }
        if ((valido) && (login.length < 6)){
            error = $('input#errlonguser').val();
            valido = false;
            $('input#inputlogin').focus();
        }
        if ((valido) && (password.length < 6)){
            error = $('input#errlongpass').val();
            valido = false;
            $('input#inputpassword').focus();
        }
        if ((valido) && (password != passconf)){
            error = $('input#errpassigual').val();
            valido = false;
            $('input#inputpassword').focus();
        }
        if(!valido) {
            alert(error);
            e.preventDefault();
        }
    });
});
