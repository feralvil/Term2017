<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/cabecera_$idioma.php";
require_once $lang;
// Buscamos el 'controlador'
$request_uri = $_SERVER['REQUEST_URI'];
$requri = explode('/', $request_uri);
$nomscript = $requri[count($requri) - 1];
$script = explode('.', $nomscript);
$cont = explode('_', $script[0]);
$controlador = $cont[0];
?>

<div class="col-md-12">
    <div class="col-md-3 text-left">
        <a href="http://www.comdes.gva.es" title="COMDES" id="COMDES" target="_blank">
            <img src="img/comdes2.png" alt="COMDES" title="COMDES" />
        </a>
    </div>
    <div class="col-md-6 text-center">
        <img src="img/fondocomdes.png" alt="COMDES" title="COMDES" />
    </div>
    <div class="col-md-3 text-right">
        <a href="http://www.hisenda.gva.es" title="Hisenda" id="Hisenda" target="_blank">
            <img src="img/logo_chap.png" alt="Hisenda" title="Hisenda" />
        </a>
    </div>
</div>
<div class="col-md-12">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?php if ($controlador == 'mapa') {echo 'class="active"';}?>>
                        <a href="mapa_cobertura.php" title="<?php echo $txtmapa;?>"><?php echo $txtmapa;?></a>
                    </li>
                    <li <?php if ($controlador == 'localizador') {echo 'class="active"';}?>>
                        <a href="localizador_gps.php" title="<?php echo $txtloc;?>"><?php echo $txtloc;?></a>
                    </li>
                    <li <?php if ($controlador == 'terminales') {echo 'class="active"';}?>>
                        <a href="terminales.php" title="<?php echo $txtterminales;?>"><?php echo $txtterminales;?></a>
                    </li>
                    <li <?php if ($controlador == 'flotas') {echo 'class="active"';}?>>
                        <a href="flotas.php" title="<?php echo $txtflotas;?>"><?php echo $txtflotas;?></a>
                    </li>
                    <li <?php if ($controlador == 'notificaciones') {echo 'class="active"';}?>>
                        <a href="notificaciones_componer.php" title="<?php echo $txtnotifica;?>"><?php echo $txtnotifica;?></a>
                    </li>
                    <li <?php if ($controlador == 'documentacion') {echo 'class="active"';}?>>
                        <a href="documentacion.php" title="<?php echo $txtdoc;?>"><?php echo $txtdoc;?></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                        if ($idioma == "es"){
                        ?>
                            <p class="navbar-text"><?php echo $txtcast;?>
                        <?php
                        }
                        else{
                        ?>
                            <a href="#" title="Castellano" id="castellano"><?php echo $txtcast;?></a>
                        <?php
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if ($idioma == "va"){
                        ?>
                            <p class="navbar-text"><?php echo $txtval;?>
                        <?php
                        }
                        else{
                        ?>
                            <a href="#" title="Valencià" id="valencia"><?php echo $txtval;?></a>
                        <?php
                        }
                        ?>
                    </li>
                    <li>
                        <a href="logout.php" title="<?php echo $txtlogout;?>" id="logout">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> <?php echo $txtlogout;?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
