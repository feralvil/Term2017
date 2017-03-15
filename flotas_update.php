<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotasupd_$idioma.php";
require_once $lang;

// Conexión a la BBDD:
require_once 'conectabbdd.php';

// Obtención del usuario
require_once 'autenticacion.php';
?>
<html>
<head>
    <title><?php echo $titulo; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Cargamos el CSS de Bootstrap -->
    <link rel="StyleSheet" type="text/css" href="css/bootstrap.css">

    <!-- JavaScript: Bootstrap y jQyery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <?php
    // Permisos de Usuario:
    // Si la sesión de Joomla ha caducado, recargamos la página principal
    $permiso = 0;
    if ($flota_usu == 0){
    ?>
        <script type="text/javascript">
            window.top.location.href = "https://intranet.comdes.gva.es/cvcomdes/";
        </script>
    <?php
    }
    else{
        if ($flota_usu == 100) {
            $permiso = 2;
        }
        else {
            if (isset($_POST['idflota'])){
                if ($flota_usu == $_POST['idflota']){
                    $permiso = 1;
                }
            }
        }
    }
    ?>
</head>
<body>
    <div class="container-fluid">
    <?php
    if ($permiso > 0){
        require_once 'sql/flotas_update.php';
    ?>
        <h1><?php echo $h1; ?></h1>
        <form name="formupdate" id="formupdate" action="<?php echo $enlace;?>" method="POST">
            <input name="idflota" type="hidden" value="<?php echo $idflota;?>">
            <input name="update" type="hidden" value="<?php echo $update;?>">
            <input name="mensflash" type="hidden" value="<?php echo $mensflash;?>">
        </form>
        <!-- Funciones jQuery -->
        <script type="text/javascript" src="js/flotas.js"></script>
         <noscript>
             <input type="submit" value="verify submit">
         </noscript>
    <?php
    }
    else{
    ?>
        <div class='panel panel-danger'>
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo  $h3perm; ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $errnoperm; ?>
            </div>
        </div>
    <?php
    }
    ?>
    </div>

</body>
