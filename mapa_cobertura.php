<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/mapacob_$idioma.php";
require_once $lang;

// Conexión a la BBDD:
require_once 'conectabbdd.php';

// Obtención del usuario
require_once 'autenticacion.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- Cargamos el CSS de Bootstrap -->
    <link rel="StyleSheet" type="text/css" href="css/bootstrap.css">

    <!-- JavaScript: Bootstrap y jQyery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Funciones jQuery -->
    <script type="text/javascript" src="js/mapa_cobertura.js"></script>
    <?php
    // Permisos de Usuario:
    // Si la sesión de Joomla ha caducado, recargamos la página principal
    $permiso = 0;
    if ($flota_usu == 0){
    ?>
        <script type="text/javascript" src="js/reload.js"></script>
    <?php
    }
    else{
        if ($flota_usu == 100) {
            $permiso = 2;
        }
    }
    ?>
</head>
<body>
    <div class="container-fluid">
        <div id="header" class="row">
            <?php require_once 'cabecera.php'; ?>
        </div>
        <h1><?php echo $h1; ?></h1>
        <form name="formidioma" id="formidioma" method="post" action="mapa_cobertura.php">
        </form>
        <div id="iframe" class="row">
            <div class="col-sm-12">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe src="https://intranet.comdes.gva.es/cvcomdes/visoricv/indexcob.php"></iframe>
                </div>
            </div>
        </div>
    </div>
</html>
