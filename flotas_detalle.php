<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotasdet_$idioma.php";
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
    <script type="text/javascript" src="js/flotas_detalle.js"></script>

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
            require_once 'sql/flotas_detalle.php';
        ?>
            <h1><?php echo $h1; ?> <?php echo $flota['FLOTA'];?></h1>
                <form name="formflotas" id="formflotas" method="post" value="flota_detalle.php" class="form-horizontal">
                    <?php
                    if ($permiso > 1){
                    ?>
                        <div class="form-group">
                            <label for="selflota" class="col-sm-2 control-label"><?php echo $txtselflota; ?></label>
                            <div class="col-sm-3">
                                <select name="idflota" id="selflota" class="form-control">
                                    <?php
                                    foreach ($selflotas as $flotasel) {
                                    ?>
                                        <option value="<?php echo $flotasel['ID'];?>" <?php if ($_POST['idflota'] == $flotasel['ID']) {echo "selected";} ?>>
                                            <?php echo $flotasel['FLOTA'];?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="btn-group col-md-6" role="group" aria-label="...">
                            <?php
                            if ($permiso > 1){
                            ?>
                                <a href="flotas.php" title="<?php echo $botatras;?>" class="btn btn-default">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $botatras;?>
                                </a>
                            <?php
                            }
                            ?>
                            <button type="button" class="btn btn-default" id="botnewtab" title="<?php echo $txtnewtab;?>">
                                <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> <?php echo $txtnewtab;?>
                            </button>
                            <button type="button" class="btn btn-default" id="botexcel" title="<?php echo $txtexcel;?>">
                                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <?php echo $txtexcel;?>
                            </button>
                            <button type="button" class="btn btn-default" id="botpdf" title="<?php echo $txtpdf;?>">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> <?php echo $txtpdf;?>
                            </button>
                        </div>
                    </div>
                </form>
                <form name="actionflota" id="actionflota" action="flotas.php" method="post">
                    <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                </form>
            <?php
            if ($nflota > 0){
            ?>
                <form name="formorg" id="formorg" action="organizaciones_detalle.php" method="post">
                    <input type="hidden" name="idorg" id="idorg" value="<?php echo $flota['ORGANIZACION'];?>" />
                </form>
                <div id="principal">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active">
                            <a href="#" id="inicio">
                                <span class="glyphicon glyphicon-home" aria-hidden="true"></span> <?php echo $txtdatos;?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#" id="contactos">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $txtcontactos;?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#" id="terminales">
                                <span class="glyphicon glyphicon-phone" aria-hidden="true"></span> <?php echo $txtterm;?>
                            </a>
                        </li>
                    </ul>
                    <div id="inicio" class="pestanya">
                        <h2><?php echo $h2flota;?></h2>
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
                                <th>Flota</th>
                                <th><?php echo $thacronimo;?></th>
                                <th><?php echo $thusuario;?></th>
                                <th><?php echo $thactiva;?></th>
                                <th><?php echo $thencripta;?></th>
                            </tr>
                            <tr>
                                <td><?php echo $flota['FLOTA'];?></td>
                                <td><?php echo $flota['ACRONIMO'];?></td>
                                <td><?php echo $flota['LOGIN'];?></td>
                                <td><?php echo $flota['ACTIVO'];?></td>
                                <td><?php echo $flota['ENCRIPTACION'];?></td>
                            </tr>
                        </table>
                        <h3><?php echo $h3localiza;?></h3>
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
                                <th><?php echo $thdomicilio;?></th>
                                <th>C.P.</th>
                                <th><?php echo $thciudad;?></th>
                                <th><?php echo $thprovincia;?></th>
                            </tr>
                            <tr>
                                <td><?php echo $flota['DOMICILIO'];?></td>
                                <td><?php echo $flota['CP'];?></td>
                                <td><?php echo $municipio['MUNICIPIO'];?></td>
                                <td><?php echo $municipio['PROVINCIA'];?></td>
                            </tr>
                        </table>
                        <h3><?php echo $h3organiza;?></h3>
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
                                <th><?php echo $thorganiza;?></th>
                                <th><?php echo $thciudad;?></th>
                                <th><?php echo $thprovincia;?></th>
                                <th><?php echo $thira . ' ' . $thorganiza;?></th>
                            </tr>
                            <tr>
                                <td><?php echo $organiza['ORGANIZACION'];?></td>
                                <td><?php echo $munorg['MUNICIPIO'];?></td>
                                <td><?php echo $munorg['PROVINCIA'];?></td>
                                <td class="text-center">
                                    <a href="#" id="linkiraorg" title="<?php echo $thira . ' ' . $thorganiza;?>">
                                        <span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <div class="form-group text-center">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default" id="botacceso" title="<?php echo $botacceso;?>">
                                    <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> <?php echo $botacceso;?>
                                </button>
                                <button type="button" class="btn btn-default" id="botgrupos" title="<?php echo $botgrupos;?>">
                                    <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> <?php echo $botgrupos;?>
                                </button>
                                <button type="button" class="btn btn-default" id="botpermiso" title="<?php echo $botpermiso;?>">
                                    <span class="glyphicon glyphicon-volume-off" aria-hidden="true"></span> <?php echo $botpermiso;?>
                                </button>
                                <?php
                                if ($permiso > 1){
                                ?>
                                    <button type="button" class="btn btn-default" id="boteditar" title="<?php echo $boteditar;?>">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <?php echo $boteditar;?>
                                    </button>
                                    <button type="button" class="btn btn-default" id="botimportar" title="<?php echo $botimportar;?>">
                                        <span class="glyphicon glyphicon-import" aria-hidden="true"></span> <?php echo $botimportar;?>
                                    </button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div id="contactos" class="pestanya hidden">
                        <h2><?php echo $h2contflota;?></h2>
                        <?php
                        if ($ncontflota > 0){
                            $menscont = $menscontno;
                            $alert = 'alert-warning';
                            $span = 'glyphicon-alert';
                            if ($flota['FORMCONT'] == 'SI'){
                                $menscont = $menscontok . ' ' . $flota['UPDCONT'];
                                $alert = 'alert-success';
                                $span = 'glyphicon-ok';
                            }
                        ?>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 alert alert-dismissible <?php echo $alert;?>">
                                    <span class="glyphicon <?php echo $span;?>" aria-hidden="true"></span> &mdash; <?php echo $menscont;?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            </div>
                        <?php
                            $indices = array('RESPORG', 'RESPONSABLE', 'OPERATIVO', 'TECNICO', 'CONT24H');
                            $h3 = array(
                                'RESPORG' => $h3resporg, 'RESPONSABLE' => $h3respflota, 'OPERATIVO' => $h3operativo,
                                'TECNICO' => $h3tecnico, 'CONT24H' => $h3cont24h
                            );
                            $errores = array(
                                'RESPORG' => $errnoresporg, 'RESPONSABLE' => $errnorespflota, 'OPERATIVO' => $errnoop,
                                'TECNICO' => $errnotec, 'CONT24H' => $errno24h
                            );
                            foreach ($indices as $indice) {
                        ?>
                                <h3><?php echo $h3[$indice];?></h3>
                                <?php
                                if (count($contactos[$indice]) > 0){
                                ?>
                                    <table class="table table-condensed table-hover table-striped">
                                        <tr>
                                            <?php
                                            if ($indice == "RESPORG"){
                                            ?>
                                                <th><?php echo $thorganiza;?></th>
                                            <?php
                                            }
                                            ?>
                                            <th><?php echo $thnombre;?></th>
                                            <?php
                                            if ($indice != "CONT24H"){
                                            ?>
                                                <th>DNI</th>
                                                <th><?php echo $thcargo;?></th>
                                            <?php
                                            }
                                            ?>
                                            <th><?php echo $thmail;?></th>
                                            <th><?php echo $thtelef;?></th>
                                        </tr>
                                        <?php
                                        foreach ($contactos[$indice] as $contacto){
                                        ?>
                                            <tr>
                                                <?php
                                                if ($indice == "RESPORG"){
                                                ?>
                                                    <td><?php echo $organiza['ORGANIZACION'];?></td>
                                                <?php
                                                }
                                                ?>
                                                <td><?php echo $contacto['NOMBRE'];?></td>
                                                <?php
                                                if ($indice != "CONT24H"){
                                                ?>
                                                    <td><?php echo $contacto['NIF'];?></td>
                                                    <td><?php echo $contacto['CARGO'];?></td>
                                                <?php
                                                }
                                                ?>
                                                <td><?php echo $contacto['MAIL'];?></td>
                                                <td><?php echo $contacto['TELEFONO'];?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                <?php
                                }
                                else {
                                ?>
                                    <p class="bg-warning">
                                        <span class="glyphicon glyphicon-alert" aria-hidden="true"></span><?php echo $errores[$indice];?>
                                    </p>
                        <?php
                                }
                            }
                        }
                        else{
                        ?>
                            <div class='panel panel-warning'>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo  $h3noresult; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo $errnocont; ?>
                                </div>
                            </div>
                        <?php
                        }
                        if ($permiso > 1){
                        ?>
                            <div class="form-group text-center">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-default" id="botcontactos" title="<?php echo $botcontactos;?>">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <?php echo $botcontactos;?>
                                    </button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div id="terminales" class="pestanya hidden">
                        <h2><?php echo $h2termflota;?></h2>
                        <h3><?php echo $h3rangoterm;?></h3>
                        <?php
                        $mensrango = $mensrangono;
                        $alert = 'alert-warning';
                        $span = 'glyphicon-alert';
                        if ($flota['RANGO'] != ""){
                            $mensrango = $flota['RANGO'];
                            $alert = 'alert-success';
                            $span = 'glyphicon-ok';
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 alert alert-dismissible <?php echo $alert;?>">
                                <span class="glyphicon <?php echo $span;?>" aria-hidden="true"></span> &mdash; <?php echo $mensrango;?>
                            </div>
                        </div>
                        <h3><?php echo $h3nterm;?></h3>
                        <?php
                        if ($ntermflota >0){
                        ?>
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th colspan="8"><?php echo $thtotterm;?></th>
                                </tr>
                                <tr>
                                    <td colspan="8" class="text-center"><?php echo $ntermflota;?></td>
                                </tr>
                                <tr>
                                    <th><?php echo $thtermbase;?></th>
                                    <th colspan="3"><?php echo $thtermmov;?></th>
                                    <th colspan="3"><?php echo $thtermport;?></th>
                                    <th><?php echo $thtermdesp;?></th>
                                </tr>
                                <tr>
                                    <td class="text-center" rowspan="3"><?php echo $nterminales['F'];?></td>
                                    <td class="text-center" colspan="3"><?php echo $nterminales['M%'];?></td>
                                    <td class="text-center" colspan="3"><?php echo $nterminales['P%'];?></td>
                                    <td class="text-center" rowspan="3"><?php echo $nterminales['D'];?></td>
                                </tr>
                                <tr>
                                    <th ><?php echo $thtermmb;?></th>
                                    <th><?php echo $thtermma;?></th>
                                    <th><?php echo $thtermmg;?></th>
                                    <th><?php echo $thtermpb;?></th>
                                    <th><?php echo $thtermpa;?></th>
                                    <th><?php echo $thtermpx;?></th>
                                </tr>
                                <tr>
                                    <td class="text-center"><?php echo $nterminales['MB'];?></td>
                                    <td class="text-center"><?php echo $nterminales['MA'];?></td>
                                    <td class="text-center"><?php echo $nterminales['MG'];?></td>
                                    <td class="text-center"><?php echo $nterminales['PB'];?></td>
                                    <td class="text-center"><?php echo $nterminales['PA'];?></td>
                                    <td class="text-center"><?php echo $nterminales['PX'];?></td>
                                </tr>
                            </table>
                        <?php
                        }
                        else {
                        ?>
                            <div class='panel panel-warning'>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo  $h3noresult; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?php echo $errrnoterm; ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group text-center">
                            <div class="btn-group" role="group" aria-label="...">
                                <?php
                                if ($permiso > 1){
                                ?>
                                    <button type="button" class="btn btn-default" id="botakdc" title="<?php echo $botakdc;?>">
                                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span> <?php echo $botakdc;?>
                                    </button>
                                    <button type="button" class="btn btn-default" id="botbase" title="<?php echo $botbase;?>">
                                        <span class="glyphicon glyphicon-headphones" aria-hidden="true"></span> <?php echo $botbase;?>
                                    </button>
                                    <button type="button" class="btn btn-default" id="botaut" title="<?php echo $botaut;?>">
                                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> <?php echo $botaut;?>
                                    </button>
                                    <button type="button" class="btn btn-default" id="botdots" title="<?php echo $botdots;?>">
                                        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> <?php echo $botdots;?>
                                    </button>
                                <?php
                                }
                                ?>
                                <button type="button" class="btn btn-default" id="botterm" title="<?php echo $botterm;?>">
                                    <span class="glyphicon glyphicon-phone" aria-hidden="true"></span> <?php echo $botterm;?>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
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
</html>
