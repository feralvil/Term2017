<?php
// Fijamos la Flota si es un usuario restringido o si se ha elegido una
$idflota = 0;
if ($permiso < 2){
    $idflota = $flota_usu;
}
else{
    if (isset($_POST['idflota'])){
        $idflota = $_POST['idflota'];
    }
}
// Consulta de tabla de flotas
if ($idflota > 0){
    $sql_flota = "SELECT * FROM flotas WHERE (flotas.ID = $idflota)";
    $res_flota = mysqli_query($link, $sql_flota) or die($errsqlflota . ': ' . mysqli_error($link));
    $nflota = mysqli_num_rows($res_flota);
}
$h1 = $titulo;
$res_update = false;
if (isset($_POST['origen'])){
    $origen = $_POST['origen'];
    $origenes = array(
        'acceso', 'editar', 'agregar', 'excel'
    );
    if (in_array($origen, $origenes)){
        // Comprobamos el permiso
        if (($permiso > 1) || (($origen == "acceso") && ($permiso == 1))){
            $res_update = true;
        }
        else{
            $error = $errpermiso;
        }
        // Comprobamos si necesitamos y tenemos flota
        if ($origen != "agregar"){
            if ($idflota > 0){
                if ($nflota > 0){
                    $flota = mysqli_fetch_assoc($res_flota);
                    mysqli_free_result($res_flota);
                }
                else{
                    $res_update = false;
                    $error = $errflota;
                }
            }
            else{
                $res_update = false;
                $error = $errnoflota;
            }
        }

        // Ejecutamos las Consultas
        if ($res_update){
            $res_update = false;
            if ($origen == "acceso"){
                $h1 = $h1acceso;
                $enlaceok = 'flotas_detalle.php';
                $enlacefail = 'flotas_acceso.php';
                $mensok = $mensacceso;
                $error = $erracceso;
                // Validaciones
                $res_update = true;
                if ($_POST['password'] == ""){
                    $res_update = false;
                    $error .= ': ' . $errpassvac;
                }
                if (($res_update) && (strlen($_POST['password']) < 6)){
                    $res_update = false;
                    $error .= ': ' . $errlongpass;
                }
                if (($res_update) && ($_POST['password'] != $_POST['passconf'])){
                    $res_update = false;
                    $error .= ': ' . $errpassigual;
                }
                if ($res_update){
                    $sql_acceso = 'UPDATE FLOTAS SET PASSWORD = "' . $_POST['password'] . '" WHERE ID = ' . $idflota;
                    $res_update = mysqli_query($link, $sql_acceso) or die($errsqlacceso . ': ' . mysqli_error($link));
                }
            }
            if ($origen == "editar"){
                $h1 = $h1editar;
                $enlaceok = 'flotas_detalle.php';
                $enlacefail = 'flotas_editar.php';
                $mensok = $menseditar;
                $error = $erreditar;
                // Validaciones
                $res_update = true;
                if ($_POST['flota'] == ""){
                    $res_update = false;
                    $error .= ': ' . $errflotavac;
                }
                if (($res_update) && ($_POST['acronimo'] == "")){
                    $res_update = false;
                    $error .= ': ' . $erracrovac;
                }
                // Comprobamos si la flota o el acrónimo están repetidos
                if ($res_update){
                    $sql_check = 'SELECT * FROM FLOTAS WHERE ((FLOTA = "' . $_POST['flota'] . '") OR (ACRONIMO = "' . $_POST['acronimo'] . '")) AND ID <> ' . $idflota;
                    $res_check = mysqli_query($link, $sql_check) or die($errsqlcheck . ': ' . $sql_check . '<br/>' . mysqli_error($link));
                    $ncheck = mysqli_num_rows($res_check);
                    if ($ncheck > 0){
                        $res_update = false;
                        $error .= ': ' . $erredirep;
                    }
                }
                if ($res_update){
                    $sql_editar = 'UPDATE FLOTAS SET FLOTA = "' . $_POST['flota'] . '", ACRONIMO = "' . $_POST['acronimo'] . '",';
                    $sql_editar .= ' ORGANIZACION = "' . $_POST['organiza'] . '", INE = "' . $_POST['ciudad'] . '",';
                    $sql_editar .= ' DOMICILIO = "' . $_POST['domicilio'] . '", CP = "' . $_POST['cp'] . '",';
                    $sql_editar .= ' ACTIVO = "' . $_POST['activo'] . '", ENCRIPTACION = "' . $_POST['encripta'] . '",';
                    $sql_editar .= ' RANGO = "' . $_POST['rangoini'] . '-' . $_POST['rangofin'] . '"';
                    $sql_editar .= ' WHERE ID = ' . $idflota;
                    $res_update = mysqli_query($link, $sql_editar) or die($errsqleditar . ': ' . mysqli_error($link));
                }
            }
        }
        else{
            if ($idflota > 0){
                $enlacefail = "flotas_detalle.php";
            }
            else{
                $enlacefail = "flotas.php";
            }
        }
    }
    else{
        $error = $errorigen;
        if ($idflota > 0){
            $enlacefail = "flotas_detalle.php";
        }
        else{
            $enlacefail = "flotas.php";
        }
    }
}
else{
    $error = $errnoorigen;
    if ($idflota > 0){
        $enlacefail = "flotas_detalle.php";
    }
    else{
        $enlacefail = "flotas.php";
    }
}
if ($res_update){
    $enlace = $enlaceok;
    $mensflash = $mensok;
    $update = "OK";
}
else{
    $enlace = $enlacefail;
    $mensflash = $error;
    $update = "KO";
}
?>
