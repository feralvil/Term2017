<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotasacc_$idioma.php";
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
    <!-- Funciones jQuery -->
    <script type="text/javascript" src="js/flotas_acceso.js"></script>

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
        <div id="header" class="row">
            <?php require_once 'cabecera.php'; ?>
        </div>
        <?php
        if ($permiso > 0){
            require_once 'sql/flotas_acceso.php';
            if ($nflota > 0){
        ?>
                <h1><?php echo $h1; ?> <?php echo $flota['FLOTA'];?></h1>
                <form name="formidioma" id="formidioma" method="post" action="flotas_acceso.php">
                    <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                </form>
                <form name="formacceso" id="formacceso" method="post" action="flotas_update.php">
                    <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                    <input type="hidden" name="origen" id="origen" value="acceso" />
                    <!-- Errores de validación  -->
                    <input type="hidden" name="errlongpass" id="errlongpass" value="<?php echo $errlongpass;?>" />
                    <input type="hidden" name="errpassigual" id="errpassigual" value="<?php echo $errpassigual;?>" />
                    <legend><?php echo $h2acceso; ?></legend>
                    <fieldset>
                        <div class="form-group col-md-4">
                            <label for="inputlogin"><?php echo $txtuser; ?></label>
                            <input type="text" name="login" class="form-control" id="inputlogin" value="<?php echo $flota['LOGIN'];?>" disabled>
                        </div>
                        <div class="form-group col-md-4 has-error">
                            <label for="inputpassword"><?php echo $txtpassword; ?></label>
                            <input type="password" name="password" class="form-control" id="inputpassword" required>
                        </div>
                        <div class="form-group col-md-4 has-error">
                            <label for="inputpassconf"><?php echo $txtpassconf; ?></label>
                            <input type="password" name="passconf" class="form-control" id="inputpassconf" required>
                        </div>
                    </fieldset>
                    <div class="form-group text-center">
                        <div class="btn-group" role="group" aria-label="...">
                            <button type="button" class="btn btn-default" id="botatras" title="<?php echo $botatras;?>">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $botatras;?>
                            </button>
                            <button type="submit" class="btn btn-default" id="botguardar" title="<?php echo $botguardar;?>">
                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> <?php echo $botguardar;?>
                            </button>
                            <button type="reset" class="btn btn-default" id="botcancel" title="<?php echo $botcancel;?>">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <?php echo $botcancel;?>
                            </button>
                        </div>
                    </div>
                </form>
                <form name="flotasdetalle" id="flotasdetalle" action="flotas_detalle.php" method="post">
                    <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                </form>
            <?php
            }
            else{
            ?>
                <div class='panel panel-warning'>
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo  $h3noresult; ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php echo $errnoresult; ?>
                    </div>
                </div>
        <?php
            }
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
