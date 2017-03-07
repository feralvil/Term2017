/*
Funciones Javascript para flotas_detalle.php
*/
// Pestañas de navegación:
$(function(){
    // Gestión de pestañas:
    $("div#principal ul li a").click(function(){
        $('div[class*=\"pestanya\"]').addClass('hidden');
        $('ul li').removeClass('active');
        $(this).parent().addClass('active');
        var divshow = $(this).attr('id');
        $('div#' + $(this).attr('id')).removeClass('hidden');
    });
    // Select de Flota:
    $("select#selflota").change(function(){
        $("form#formflotas").submit();
    });
    // Botón Exportar a PDF:
    $("button#botpdf").click(function(){
        $("form#actionflota").attr('action', 'flotas_detpdf.php');
        $("form#actionflota").attr('target', '_blank');
        $("form#actionflota").submit();
        $("form#actionflota").attr('target', '_self');
        $("form#actionflota").attr('action', 'flotas.php');
   });
   // Botón Exportar a Excel:
   $("button#botexcel").click(function(){
       $("form#actionflota").attr('action', 'flotas_detexcel.php');
       $("form#actionflota").attr('target', '_blank');
       $("form#actionflota").submit();
       $("form#actionflota").attr('target', '_self');
       $("form#actionflota").attr('action', 'flotas.php');
   });
   // Botón Nueva Pestaña:
   $("button#botnewtab").click(function(){
       $("form#actionflota").attr('action', 'flotas_detalle.php');
       $("form#actionflota").attr('target', '_blank');
       $("form#actionflota").submit();
       $("form#actionflota").attr('target', '_self');
       $("form#actionflota").attr('action', 'flotas.php');
   });
   // Botón acceso:
   $("button#botacceso").click(function(){
       $("form#actionflota").attr('action', 'flotas_acceso.php');
       $("form#actionflota").submit();
   });

   // Botón Grupos:
   $("button#botgrupos").click(function(){
       $("form#actionflota").attr('action', 'flotas_grupos.php');
       $("form#actionflota").submit();
   });

   // Botón Permiso:
   $("button#botpermiso").click(function(){
       $("form#actionflota").attr('action', 'flotas_permiso.php');
       $("form#actionflota").submit();
   });

   // Botón Editar:
   $("button#boteditar").click(function(){
       $("form#actionflota").attr('action', 'flotas_editar.php');
       $("form#actionflota").submit();
   });
   // Botón Importar:
   $("button#botimportar").click(function(){
       $("form#actionflota").attr('action', 'flotas_importar.php');
       $("form#actionflota").submit();
   });
   // Botón Contactos:
   $("button#botcontactos").click(function(){
       $("form#actionflota").attr('action', 'flotas_contactos.php');
       $("form#actionflota").submit();
   });
   // Botón AKDC:
   $("button#botakdc").click(function(){
       $("form#actionflota").attr('action', 'flotas_akdc.php');
       $("form#actionflota").submit();
   });
   // Botón Base:
   $("button#botbase").click(function(){
       $("form#actionflota").attr('action', 'flotas_base.php');
       $("form#actionflota").submit();
   });
   // Botón Autenticación:
   $("button#botaut").click(function(){
       $("form#actionflota").attr('action', 'flotas_autentica.php');
       $("form#actionflota").submit();
   });
   // Botón DOTS:
   $("button#botdots").click(function(){
       $("form#actionflota").attr('action', 'flotas_dots.php');
       $("form#actionflota").submit();
   });
   // Botón Terminales:
   $("button#botterm").click(function(){
       $("form#actionflota").attr('action', 'terminales.php');
       $("form#actionflota").submit();
   });
   // Enlace Organización:
   $("a#linkiraorg").click(function(){
       $("form#formorg").submit();
   });
});
