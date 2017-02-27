<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotas_$idioma.php";
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
    <script type="text/javascript" src="js/flotas.js"></script>

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
    }
    ?>
</head>
<body>
    <div class="container-fluid">
        <h1><?php echo $h1; ?></h1>
        <?php
        if ($permiso > 1){
            require_once 'sql_flotas.php';
            $nflotas = count($flotas);
        ?>
            <form name="formflotas" id="formflotas" method="post" value="flotas.php" class="form-horizontal">
                <input type="hidden" name="pagina" id="inputpag" value="<?php echo $pagina;?>" />
                <input type="hidden" name="npaginas" id="inputnpag" value="<?php echo $npaginas;?>" />
                <fieldset>
                    <legend>
                        <?php echo $txtcriterios;?> &mdash;
                        <a href="flotas.php" id="flotas" title="<?php echo $txtreset;?>">
                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                        </a>
                    </legend>
                    <div class="form-group">
                        <label for="selorg" class="col-sm-2 control-label"><?php echo $txtorg;?></label>
                        <div class="col-sm-6">
                            <select name="idorg" id="selorg" class="form-control">
                                <option value="0">Seleccionar</option>
                                <?php
                                foreach ($selorganiza as $organiza) {
                                ?>
                                    <option value="<?php echo $organiza['ID'];?>" <?php if ($_POST['idorg'] == $organiza['ID']) {echo "selected";} ?>>
                                        <?php echo $organiza['ORGANIZACION'];?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selflota" class="col-sm-2 control-label">Flota</label>
                        <div class="col-sm-6">
                            <select name="idflota" id="selflota" class="form-control">
                                <option value="0">Seleccionar</option>
                                <?php
                                foreach ($selflotas as $flota) {
                                ?>
                                    <option value="<?php echo $flota['ID'];?>" <?php if ($_POST['idflota'] == $flota['ID']) {echo "selected";} ?>>
                                        <?php echo $flota['FLOTA'];?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <label for="selcont" class="col-sm-2 control-label"><?php echo $txtcontof;?></label>
                        <div class="col-sm-2">
                            <select name="formcont" id="selcont" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="SI" <?php if ($_POST['formcont'] == 'SI') {echo "selected";} ?>>Sí</option>
                                <option value="NO" <?php if ($_POST['formcont'] == 'NO') {echo "selected";} ?>>No</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>
                        <?php
                        echo $txtresult;
                        if ($nflotas > 0){
                            echo ' &mdash; ';
                            echo sprintf($txtflotas, $inicio + 1, $inicio + $nflotas, $nsinpag);
                        }
                        ?>
                    </legend>
                    <div class="form-group">
                        <label for="seltampag" class="col-sm-2 control-label"><?php echo $txttampag;?></label>
                        <div class="col-sm-1">
                            <select name="tampagina" id="seltampag" class="form-control">
                                <?php
                                $tampag = array(30 => 30, 50 =>50, 100 => 100, $nsinpag => $txttodo);
                                foreach ($tampag as $indice => $valor) {
                                ?>
                                    <option value="<?php echo $indice;?>" <?php if ($_POST['tampagina'] == $indice) {echo "selected";} ?>><?php echo $valor;?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="text-center col-md-4 btn-group" aria-label="...">
                            <?php
                            $clase = "btn btn-default";
                            if ($pagina == 1){
                             $clase .= " disabled";
                            }
                            ?>
                            <button type="button" class="<?php echo $clase;?>" id="primera" title="<?php echo $txtpagpri;?>">
                                 &nbsp; <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span> &nbsp;
                            </button>
                            <?php
                            $clase = "btn btn-default";
                            if ($pagina == 1){
                                $clase .= " disabled";
                            }
                            ?>
                            <button type="button" class="<?php echo $clase;?>" id="anterior" title="<?php echo $txtpagant;?>">
                                &nbsp; <span class="glyphicon glyphicon-backward" aria-hidden="true"></span> &nbsp;
                            </button>
                            <?php
                            $clase = "btn btn-default";
                            ?>
                            <button type="button" class="<?php echo $clase;?>" id="actual" title="<?php echo $txtpagact;?>">
                                <?php echo $txtpagina . ' ' . $pagina . '/' . $npaginas; ?>
                            </button>
                            <?php
                            $clase = "btn btn-default";
                            if ($pagina == $npaginas){
                                $clase .= " disabled";
                            }
                            ?>
                            <button type="button" class="<?php echo $clase;?>" id="siguiente" title="<?php echo $txtpagsig;?>">
                                &nbsp; <span class="glyphicon glyphicon-forward" aria-hidden="true"></span> &nbsp;
                            </button>
                            <?php
                            $clase = "btn btn-default";
                            if ($pagina == $npaginas){
                                $clase .= " disabled";
                            }
                            ?>
                            <button type="button" class="<?php echo $clase;?>" id="ultima" title="<?php echo $txtpagult;?>">
                                &nbsp; <span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span> &nbsp;
                            </button>
                        </div>
                        <div class="btn-group col-md-4" role="group" aria-label="...">
                            <a href="flotas_agregar.php" title="<?php echo $txtaddflota;?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> <?php echo $txtaddflo;?>
                            </a>
                            <a href="flotas.php" title="<?php echo $txtnewtab;?>" class="btn btn-default" target="_blank">
                                <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> <?php echo $txtampliar;?>
                            </a>
                            <button type="button" class="btn btn-default" id="xlsflotas" title="<?php echo $txtexcel;?>">
                                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Excel
                            </button>
                            <button type="button" class="btn btn-default" id="pdfflotas" title="<?php echo $txtpdf;?>">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span> PDF
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <form id="detalle" method="POST" action="flotas_detalle.php" role="form">
                <input type="hidden" name="idflota" id="idflota" value="100">
            </form>
            <?php
            if ($nflotas > 0){
            ?>
                <table class="table table-condensed table-hover table-striped table-bordered">
                    <tr>
                        <th><?php echo $thacciones; ?></th>
                        <th><?php echo $txtorg; ?></th>
                        <th>Flota</th>
                        <th><?php echo $thacronimo; ?></th>
                        <th><?php echo $thencripta; ?></th>
                        <th><?php echo $thnterm; ?></th>
                    </tr>
                    <?php
                    foreach ($flotas as $flota) {
                    ?>
                        <tr>
                            <td class="text-center">
                                <a href="#" id="<?php echo $flota["ID"];?>" name="id-<?php echo $flota["ID"];?>" title="<?php echo $txtdetflota;?>">
                                    <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                                </a>
                            </td>
                            <td><?php echo $flota['ORGANIZACION'];?></td>
                            <td><?php echo $flota['FLOTA'];?></td>
                            <td><?php echo $flota['ACRONIMO'];?></td>
                            <td><?php echo $flota['ENCRIPTACION'];?></td>
                            <td><?php echo $flota['NTERM'];?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
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
