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
// Consulta de tabla de flotas (limitada)
$sql_flota = "SELECT * FROM flotas WHERE (flotas.ID = $idflota)";
$res_flota = mysqli_query($link, $sql_flota) or die($errsqlflota . ': ' . mysqli_error($link));
$nflota = mysqli_num_rows($res_flota);
if ($nflota > 0){
    $flota = mysqli_fetch_assoc($res_flota);
    mysqli_free_result($res_flota);
    // Consulta de municipio:
    $idmuni = $flota['INE'];
    $sql_muni = "SELECT * FROM municipios WHERE (municipios.INE = $idmuni)";
    $res_muni = mysqli_query($link, $sql_muni) or die($errsqlmuni . ': ' . mysqli_error($link));
    $nmuni = mysqli_num_rows($res_muni);
    if ($nmuni > 0){
        $municipio = mysqli_fetch_assoc($res_muni);
        mysqli_free_result($res_muni);
    }
    // Select de Municipios
    $sql_selmuni = "SELECT INE, MUNICIPIO FROM municipios ORDER BY municipios.MUNICIPIO ASC";
    $res_selmuni = mysqli_query($link, $sql_selmuni) or die($errsqlselmuni . ": " . mysqli_error($link));
    $nselmuni = mysqli_num_rows($res_selmuni);
    // Construimos el Select de Municipios:
    $selmuni = array();
    while ($munisel = mysqli_fetch_assoc($res_selmuni)){
        $selmuni[] = array('INE' => $munisel['INE'], 'MUNICIPIO' => $munisel['MUNICIPIO']);
    }
    mysqli_free_result($res_selmuni);
    // Select de Organizaciones
    $sql_selorg = "SELECT ID, ORGANIZACION FROM organizaciones ORDER BY organizaciones.ORGANIZACION ASC";
    $res_selorg = mysqli_query($link, $sql_selorg) or die($errsqlselorg . ": " . mysqli_error($link));
    $nselorg = mysqli_num_rows($res_selorg);
    // Construimos el Select de Organizaciones:
    $selorg = array();
    while ($orgsel = mysqli_fetch_assoc($res_selorg)){
        $selorg[] = array('ID' => $orgsel['ID'], 'ORGANIZACION' => $orgsel['ORGANIZACION']);
    }
    mysqli_free_result($res_selorg);
}
?>
