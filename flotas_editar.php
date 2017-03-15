<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotasedi_$idioma.php";
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
    <script type="text/javascript" src="js/flotas_editar.js"></script>

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
            require_once 'sql/flotas_editar.php';
            if ($nflota > 0){
        ?>
                <h1><?php echo $h1; ?> <?php echo $flota['FLOTA'];?></h1>
                <form name="formidioma" id="formidioma" method="post" action="flotas_editar.php">
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
                <form name="formeditar" id="formeditar" method="post" action="flotas_update.php">
                    <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                    <input type="hidden" name="origen" id="origen" value="editar" />
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
                            <label for="inputactiva"><?php echo $txtactiva; ?></label>
                            <select name="activo" id="inputactiva" class="form-control">
                                <option value="NO" <?php if ($flota['ACTIVO'] == 'NO'){ echo "selected";}?>>No</option>
                                <option value="SI" <?php if ($flota['ACTIVO'] == 'SI'){ echo "selected";}?>>Sí</option>
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
                            <input type="text" name="domicilio" class="form-control" id="inputdomic" required value="<?php echo $flota['DOMICILIO']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputcp"><?php echo $txtcp; ?></label>
                            <input type="text" name="cp" class="form-control" id="inputcp" required value="<?php echo $flota['CP']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputciudad"><?php echo $txtciudad; ?></label>
                            <select name="ciudad" id="inputciudad" class="form-control">
                                <?php
                                foreach ($selmuni as $munisel) {
                                ?>
                                    <option value="<?php echo $munisel['INE'];?>" <?php if ($flota['INE'] == $munisel['INE']) {echo "selected";} ?>>
                                        <?php echo $munisel['MUNICIPIO'];?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="col-md-5">
                            <legend><?php echo $h2organiza; ?></legend>
                            <label for="inputorg"><?php echo $txtorganiza; ?></label>
                            <fieldset>
                                <div class="form-group">
                                    <select name="organiza" id="inputorg" class="form-control">
                                        <?php
                                        foreach ($selorg as $orgsel) {
                                        ?>
                                            <option value="<?php echo $orgsel['ID'];?>" <?php if ($flota['ORGANIZACION'] == $orgsel['ID']) {echo "selected";} ?>>
                                                <?php echo $orgsel['ORGANIZACION'];?>
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
                                <?php
                                $rango = array('','');
                                if ($flota['RANGO'] != ""){
                                    $rango = explode('-', $flota['RANGO']);
                                }
                                ?>
                                <div class="form-group col-md-3">
                                    <label for="inputrangoini"><?php echo $txtini; ?></label>
                                    <input type="text" name="rangoini" id="inputrangoini" class="form-control" required value="<?php echo $rango[0]; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputrangofin"><?php echo $txtfin; ?></label>
                                    <input type="text" name="rangofin" id="inputrangofin" class="form-control" required value="<?php echo $rango[1]; ?>">
                                </div>
                            </fieldset>
                        </div>

                    </div>


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
