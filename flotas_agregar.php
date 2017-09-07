<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotasagr_$idioma.php";
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
    <script type="text/javascript" src="js/flotas_agregar.js"></script>

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
        <?php
        if ($permiso > 1){
            require_once 'sql/flotas_agregar.php';
        ?>
            <h1><?php echo $h1; ?></h1>
            <form name="formidioma" id="formidioma" method="post" action="flotas_agregar.php">
                <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
            </form>
            <?php
            if (isset($_POST['update'])){
                if ($_POST['update'] == 'OK'){
                    $alert = 'alert-success';
                    $span = 'glyphicon-ok';
                }
                else{
                    $alert = 'alert-warning';
                    $span = 'glyphicon-alert';
                }
            ?>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 alert alert-dismissible <?php echo $alert;?>">
                        <span class="glyphicon <?php echo $span;?>" aria-hidden="true"></span> &mdash; <?php echo $_POST['mensflash'];?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            <?php
            }
            ?>
            <form enctype="multipart/form-data" name="formagregar" id="formagregar" method="post" action="flotas_update.php">
                <input type="hidden" name="origen" id="origen" value="agregar" />
                <!-- Errores de validación  -->
                <input type="hidden" name="errlonguser" id="errlongflota" value="<?php echo $errlongflota;?>" />
                <input type="hidden" name="errlonguser" id="errlonguser" value="<?php echo $errlonguser;?>" />
                <input type="hidden" name="errlongpass" id="errlongpass" value="<?php echo $errlongpass;?>" />
                <input type="hidden" name="errpassigual" id="errpassigual" value="<?php echo $errpassigual;?>" />
                <legend><?php echo $h2flota; ?></legend>
                <fieldset>
                    <div class="form-group col-md-6 has-error">
                        <label for="inputflota"><?php echo $txtnombre; ?></label>
                        <input type="text" name="flota" class="form-control" id="inputflota" required value="<?php echo $flota['FLOTA']; ?>">
                    </div>
                    <div class="form-group col-md-2 has-error">
                        <label for="inputacro"><?php echo $txtacronimo; ?></label>
                        <input type="text" name="acronimo" class="form-control" id="inputacro" required value="<?php echo $flota['ACRONIMO']; ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputambito"><?php echo $thambito; ?></label>
                        <select name="ambito" id="inputambito" class="form-control">
                            <?php
                            $ambitos = array('NADA' => $txtambnada, 'LOC' => $txtambloc, 'PROV' => $txtambprov, 'AUT' => $txtambaut);
                            foreach ($ambitos as $idamb => $txtamb) {
                            ?>
                                <option value="<?php echo $idamb;?>">
                                    <?php echo $txtamb;?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputencripta"><?php echo $txtencripta; ?></label>
                        <select name="encripta" id="inputencripta" class="form-control">
                            <option value="NO" <?php if ($flota['ENCRIPTACION'] == 'NO'){ echo "selected";}?>>No</option>
                            <option value="SI" <?php if ($flota['ENCRIPTACION'] == 'SI'){ echo "selected";}?>>Sí</option>
                        </select>
                    </div>
                </fieldset>
                <legend><?php echo $h2localiza; ?></legend>
                <fieldset>
                    <div class="form-group col-md-4">
                        <label for="inputdomic"><?php echo $txtdomicilio; ?></label>
                        <input type="text" name="domicilio" class="form-control" id="inputdomic">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputcp"><?php echo $txtcp; ?></label>
                        <input type="text" name="cp" class="form-control" id="inputcp">
                    </div>
                    <div class="form-group col-md-6 has-error">
                        <label for="inputciudad"><?php echo $txtciudad; ?></label>
                        <select name="ciudad" id="inputciudad" class="form-control" required>
                            <option value="">Seleccionar</option>
                            <?php
                            foreach ($selmuni as $muni_id => $muni_nom) {
                            ?>
                                <option value="<?php echo $muni_id;?>">
                                    <?php echo $muni_nom;?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </fieldset>
                <legend><?php echo $h2acceso; ?></legend>
                <fieldset>
                    <div class="form-group col-md-4 has-error">
                        <label for="inputlogin"><?php echo $txtuser; ?></label>
                        <input type="text" name="login" class="form-control" id="inputlogin" required>
                    </div>
                    <div class="form-group col-md-4 has-error">
                        <label for="inputpassword"><?php echo $txtpassword; ?></label>
                        <input type="password" name="password" id="inputpassword" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4 has-error">
                        <label for="inputpassconf"><?php echo $txtpassconf; ?></label>
                        <input type="password" name="passconf" class="form-control" id="inputpassconf" required>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-5">
                        <legend><?php echo $h2organiza; ?></legend>
                        <label for="inputorg"><?php echo $txtorganiza; ?></label>
                        <fieldset>
                            <div class="form-group has-error">
                                <select name="organiza" id="inputorg" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                    foreach ($selorg as $org_id => $org_nom) {
                                    ?>
                                        <option value="<?php echo $org_id;?>">
                                            <?php echo $org_nom;?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-2">
                        &nbsp;
                    </div>
                    <div class="col-md-5">
                        <legend><?php echo $h2rango; ?></legend>
                        <fieldset>
                            <div class="form-group col-md-3">
                                <label for="inputrangoini"><?php echo $txtini; ?></label>
                                <input type="text" name="rangoini" id="inputrangoini" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputrangofin"><?php echo $txtfin; ?></label>
                                <input type="text" name="rangofin" id="inputrangofin" class="form-control">
                            </div>
                        </fieldset>
                    </div>
                </div>
                <legend><?php echo $h2fichero; ?></legend>
                <fieldset>
                    <div class="form-group col-md-6">
                        <label for="inputfichero"><?php echo $txtarchivo; ?></label>
                        <input type="file" name="fichero" class="form-control" id="inputfichero" accept=".xls,.xslx,.ods">
                    </div>
                </fieldset>
                <div class="form-group text-center">
                    <div class="btn-group" role="group" aria-label="...">
                        <a href="flotas.php" title="<?php echo $botatras;?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $botatras;?>
                        </a>
                        <button type="submit" class="btn btn-default" id="botguardar" title="<?php echo $botguardar;?>">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> <?php echo $botguardar;?>
                        </button>
                        <button type="reset" class="btn btn-default" id="botcancel" title="<?php echo $botcancel;?>">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <?php echo $botcancel;?>
                        </button>
                    </div>
                </div>
            </form>
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
