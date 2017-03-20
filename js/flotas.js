/*
Funciones Javascript para flotas.php
*/
$(function(){
    // Cambio en el select de Flota:
    $("select").change(function(){
        $("input#inputpag").val(1);
        $("form#formflotas").submit();
    });
    // Botón Primera página
    $("button#primera").click(function(){
        $("input#inputpag").val(1);
        $("form#formflotas").submit();
    });
    // Botón Página anterior
    $("button#anterior").click(function(){
        var newpag =  $("input#inputpag").val();
        newpag--;
        $("input#inputpag").val(newpag);
        $("form#formflotas").submit();
    });
    // Botón página siguiente:
    $("button#siguiente").click(function(){
        var newpag =  $("input#inputpag").val();
        newpag++;
        $("input#inputpag").val(newpag);
        $("form#formflotas").submit();
    });
    // Botón Última página
    $("button#ultima").click(function(){
        $("input#inputpag").val($("input#inputnpag").val());
        $("form#formflotas").submit();
    });
    // Botón Exportar a PDF:
    $("button#pdfflotas").click(function(){
        $("form#formflotas").attr('action', 'flotas_pdf.php');
        $("form#formflotas").attr('target', '_blank');
        $("form#formflotas").submit();
        $("form#formflotas").attr('target', '_self');
        $("form#formflotas").attr('action', 'flotas.php');
   });
    // Botón Exportar a Excel:
    $("button#xlsflotas").click(function(){
        $("form#formflotas").attr('action', 'flotas_excel.php');
        $("form#formflotas").attr('target', '_blank');
        $("form#formflotas").submit();
        $("form#formflotas").attr('target', '_self');
        $("form#formflotas").attr('action', 'flotas.php');
    });
    // Link detalle:
    $("a[name^=id]").click(function(){
        var idflota = $(this).attr('id');
        $("input#idflota").val(idflota);
        $("form#detalle").submit();
    });
    //Cambio de idioma - VA:
    $("a#valencia").click(function(){
        // Modificamos la cookie de idioma:
        document.cookie = "idioma=va";
        $("form#formflotas").submit();
    });
    //Cambio de idioma - ES:
    $("a#castellano").click(function(){
        // Modificamos la cookie de idioma:
        document.cookie = "idioma=es";
        $("form#formflotas").submit();
    });
});
