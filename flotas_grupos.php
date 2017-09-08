<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotasgrup_$idioma.php";
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
    <script type="text/javascript" src="js/flotas_grupos.js"></script>

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
            include_once 'sql/flotas_grupos.php';
        ?>
            <h1><?php echo $h1;?></h1>
            <form name="formidioma" id="formidioma" method="post" action="flotas_grupos.php">
                <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
            </form>
            <?php
            if ($nflota > 0){
            ?>
                <h2><?php echo $h2flota; ?></h2>
                <table class="table table-condensed table-hover table-striped">
                    <tr>
                        <th>Flota</th>
                        <th><?php echo $thacro;?></th>
                        <th><?php echo $thorganiza;?></th>
                    </tr>
                    <tr>
                        <td><?php echo $flota['FLOTA'];?></td>
                        <td><?php echo $flota['ACRONIMO'];?></td>
                        <td><?php echo $organiza['ORGANIZACION'];?></td>
                    </tr>
                </table>
            <?php
            }
            else{
            ?>
                <div class='panel panel-danger'>
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo  $h3errnoflota; ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php echo $errnoflota; ?>
                    </div>
                </div>
            <?php
            }
            ?>
            <h2><?php echo $h2grupos; ?></h2>
            <form name="formaccion" id="formaccion" method="post" action="nada">
                <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                <input type="hidden" name="accion" value="impgrupos" />
            </form>
            <div class="form-group text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" id="botatras" title="<?php echo $botatras;?>">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $botatras;?>
                    </button>
                    <?php
                    if ($permiso > 1){
                    ?>
                        <button type="button" class="btn btn-default" id="botadd" title="<?php echo $botadd;?>">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo $botadd;?>
                        </button>
                        <button type="button" class="btn btn-default" id="botdel" title="<?php echo $botdel;?>">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> <?php echo $botdel;?>
                        </button>
                        <button type="button" class="btn btn-default" id="botexcel" title="<?php echo $botexcel;?>">
                            <span class="glyphicon glyphicon-import" aria-hidden="true"></span> <?php echo $botexcel;?>
                        </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            if ($ngrupos > 0){
            ?>
                <table class="table table-condensed table-hover table-striped">
                    <tr>
                    <?php
                    for ($i = 1; $i <= $ncarpetas; $i++){
                    ?>
                        <th colspan="2">CARPETA <?php echo $i;?></th>
                    <?php
                    }
                    ?>
                    </tr>
                    <tr>
                    <?php
                    for ($i = 1; $i <= $ncarpetas; $i++){
                    ?>
                        <th colspan="2"><?php echo $grupos[$i]['NOMBRE'];?></th>
                    <?php
                    }
                    ?>
                    </tr>
                    <tr>
                    <?php
                    for ($i = 1; $i <= $ncarpetas; $i++){
                    ?>
                        <th>GSSI</th>
                        <th><?php echo $thmnemo;?></th>
                    <?php
                    }
                    ?>
                    </tr>
                    <?php
                    for ($i = 0; $i < $ngcmax; $i++){
                    ?>
                        <tr>
                        <?php
                        for($j = 1; $j <= $ncarpetas; $j++){
                            if ($i > count($grupos[$j]['GISSI'])){
                        ?>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            <?php
                            }
                            else{
                            ?>
                                <td><?php echo $grupos[$j]['GISSI'][$i]['GISSI'];?></td>
                                <td><?php echo $grupos[$j]['GISSI'][$i]['MNEMO'];?></td>
                        <?php
                            }
                        }
                        ?>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            }
            else{
            ?>
                <p class="bg-warning">
                    <span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <?php echo $errnogrupos;?>
                </p>
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
