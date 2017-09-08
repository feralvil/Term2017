<?php
// Select de Flotas
$sql_selflotas = "SELECT ID, FLOTA FROM flotas WHERE 1";
if ((isset($_POST['idorg']))&&($_POST['idorg'] > 0)){
    $sql_selflotas .=  " AND (flotas.ORGANIZACION = " . $_POST['idorg'] .")";
}
$sql_selflotas .= " ORDER BY flotas.FLOTA ASC";
$res_selflotas = mysqli_query($link, $sql_selflotas) or die($errsqlselflo . ": " . mysqli_error($link));
$nselflotas = mysqli_num_rows($res_selflotas);
// Construimos el Select de Flotas:
$selflotas = array();
while ($flotasel = mysqli_fetch_assoc($res_selflotas)){
    $selflotas[$flotasel['ID']] = $flotasel['FLOTA'];
}
mysqli_free_result($res_selflotas);

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
// Consulta de tabla de la flota
$sql_flota = "SELECT * FROM flotas WHERE (flotas.ID = $idflota)";
$res_flota = mysqli_query($link, $sql_flota) or die($errsqlflota . ': ' . mysqli_error($link));
$nflota = mysqli_num_rows($res_flota);
if ($nflota > 0){
    $flota = mysqli_fetch_assoc($res_flota);
    mysqli_free_result($res_flota);
    // Consulta de la Organización de la Flota:
    $idorg = $flota['ORGANIZACION'];
    $sql_organiza = "SELECT * FROM organizaciones WHERE (organizaciones.ID = $idorg)";
    $res_organiza = mysqli_query($link, $sql_organiza) or die($errsqlorganiza . ': ' . mysqli_error($link));
    $norganiza = mysqli_num_rows($res_organiza);
    if ($norganiza > 0){
        $organiza = mysqli_fetch_assoc($res_organiza);
        mysqli_free_result($res_organiza);
    }
    $sql_grupos = "SELECT grupos_flotas.*, grupos.MNEMONICO FROM grupos_flotas, grupos";
    $sql_grupos .= " WHERE (grupos_flotas.GISSI = grupos.GISSI) AND (grupos_flotas.FLOTA = " . $idflota . ")";
    $sql_grupos .= " ORDER BY grupos_flotas.CARPETA, grupos_flotas.GISSI";
    $res_grupos = mysqli_query($link, $sql_grupos) or die($errsqlgrupos . ': ' . mysql_error());
    $ngrupos = mysqli_num_rows($res_grupos);
    if ($ngrupos > 0){
        $grupos = array();
        $carpeta = 0;
        $ngcmax = 0;
        $ngc = 0;
        $gissicarpeta = array();
        $grupos_consulta = array();
        for ($i = 0; $i < $ngrupos; $i++){
            $grupo = mysqli_fetch_assoc($res_grupos);
            $grupos_consulta[$i] = $grupo;
            if ($grupo['CARPETA'] > $carpeta){
                // Cerramos la carpeta anterior
                if (count ($gissicarpeta) > 0){
                    $grupos[$carpeta]['NOMBRE'] =  $nombre;
                    $grupos[$carpeta]['GISSI'] = $gissicarpeta;
                    $gissicarpeta = array();
                    if ($ngc > $ngcmax){
                        $ngcmax = $ngc;
                    }
                    $ngc = 0;
                }
                $gissifila = array('GISSI' => $grupo['GISSI'], 'MNEMO' => $grupo['MNEMONICO']);
                $carpeta = $grupo['CARPETA'];
                $nombre = $grupo['NOMBRE'];
                array_push($gissicarpeta, $gissifila);
                $ngc++;
            }
            else{
                $gissifila = array('GISSI' => $grupo['GISSI'], 'MNEMO' => $grupo['MNEMONICO']);
                array_push($gissicarpeta, $gissifila);
                $ngc++;
            }
        }
        $grupos[$carpeta]['NOMBRE'] =  $nombre;
        $grupos[$carpeta]['GISSI'] = $gissicarpeta;
        $ncarpetas = count($grupos);
    }
}
mysqli_close($link);
?>
