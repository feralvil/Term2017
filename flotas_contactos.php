<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotascon_$idioma.php";
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
    <script type="text/javascript" src="js/flotas_contactos.js"></script>

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
        <?php
        if ($permiso > 1){
            require_once 'sql/flotas_contactos.php';
            if ($nflota > 0){
        ?>
                <h1><?php echo $h1; ?> <?php echo $flota['FLOTA'];?></h1>
                <form name="flotasdetalle" id="flotasdetalle" action="flotas_detalle.php" method="post">
                    <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                </form>
                <form name="contactoflota" id="contactoflota" action="contactos_update.php" method="post">
                    <input type="hidden" name="idflota" id="idflota" value="<?php echo $idflota;?>" />
                    <input type="hidden" name="idcontacto" id="idcontacto" value="0" />
                    <input type="hidden" name="origen" id="origen" value="borrar" />
                    <input type="hidden" name="rol" id="rol" value="nada" />
                    <!-- Mensajes alert  -->
                    <input type="hidden" name="mensdel" id="mensdel" value="<?php echo $txtmensdel;?>" />
                </form>
                <h2><?php echo $h2flota; ?></h2>
                <table class="table table-condensed table-hover table-striped">
                    <tr>
                        <th>Flota</th>
                        <th><?php echo $thacronimo;?></th>
                        <th><?php echo $thorganiza;?></th>
                    </tr>
                    <tr>
                        <td><?php echo $flota['FLOTA'];?></td>
                        <td><?php echo $flota['ACRONIMO'];?></td>
                        <td><?php echo $flota['ORGANIZACION'];?></td>
                    </tr>
                </table>
                <h2><?php echo $h2contflota; ?></h2>
                <?php
                $indices = array('RESPONSABLE', 'OPERATIVO', 'TECNICO', 'CONT24H');
                $h3 = array(
                'RESPONSABLE' => $h3respflota, 'OPERATIVO' => $h3operativo,
                    'TECNICO' => $h3tecnico, 'CONT24H' => $h3cont24h
                );
                $errores = array(
                    'RESPONSABLE' => $errnorespflota, 'OPERATIVO' => $errnoop,
                    'TECNICO' => $errnotec, 'CONT24H' => $errno24h
                );
                foreach ($indices as $indice) {
                ?>
                    <h3>
                        <?php
                        echo $h3[$indice];
                        if (($indice != 'RESPONSABLE') || (($indice == 'RESPONSABLE') && (count($contactos['RESPONSABLE']) == 0))){
                        ?>
                         &mdash;
                        <a href="#" name="add-<?php echo $indice;?>"  id="<?php echo $indice;?>" title="<?php echo $txtaddcont;?>">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                        <?php
                        }
                        ?>
                    </h3>
                    <?php
                    if (count($contactos[$indice]) > 0){
                    ?>
                        <table class="table table-condensed table-hover table-striped">
                            <tr>
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
                                <th><?php echo $thacciones;?></th>
                            </tr>
                            <?php
                            foreach ($contactos[$indice] as $contacto){
                            ?>
                                <tr>
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
                                    <td class="text-center">
                                        <a href="#" id="<?php echo $contacto["ID"];?>" name="edi-<?php echo $indice;?>" title="<?php echo $txtedicont;?>">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a> &mdash;
                                        <a href="#" id="<?php echo $contacto["ID"];?>" name="del-<?php echo $indice;?>" title="<?php echo $txtdelcont;?>">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </a>
                                    </td>
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
                            <span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <?php echo $errores[$indice];?>
                        </p>
            <?php
                    }
                }
            ?>
                <div class="form-group text-center">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="button" class="btn btn-default" id="botatras" title="<?php echo $botvolver;?>">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <?php echo $botvolver;?>
                        </button>
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
