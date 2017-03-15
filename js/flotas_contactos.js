/*
Funciones Javascript para flotas_contactos.php
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
    // Enlace agregar:
    $("a[name^=add]").click(function(){
        var rol = $(this).attr('id');
        $("input#rol").val(rol);
        $("form#contactoflota").attr('action', 'contactos_agregar.php');
        $("form#contactoflota").submit();
    });
    // Enlace editar:
    $("a[name^=edi]").click(function(){
        var idcontacto = $(this).attr('id');
        var rolname = $(this).attr('name');
        var rol = rolname.substr(4);
        $("input#rol").val(rol);
        $("input#idcontacto").val(idcontacto);
        $("form#contactoflota").attr('action', 'contactos_editar.php');
        $("form#contactoflota").submit();
    });
    // Enlace borrar:
    $("a[name^=del]").click(function(){
        var idcontacto = $(this).attr('id');
        var rolname = $(this).attr('name');
        var rol = rolname.substr(4);
        var textoconf = $("input#mensdel").val();
        var enviar = confirm(textoconf)
        if (enviar){
            $("input#rol").val(rol);
            $("input#idcontacto").val(idcontacto);
            $("form#contactoflota").submit();
        }
    });
});
