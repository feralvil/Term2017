<?php
// Fijamos la Flota si es un usuario restringido o si se ha elegido una
$sql_selmuni = "SELECT INE, MUNICIPIO FROM municipios ORDER BY municipios.MUNICIPIO ASC";
$res_selmuni = mysqli_query($link, $sql_selmuni) or die($errsqlselmuni . ": " . mysqli_error($link));
$nselmuni = mysqli_num_rows($res_selmuni);
// Construimos el Select de Municipios:
$selmuni = array();
while ($munisel = mysqli_fetch_assoc($res_selmuni)){
    $selmuni[$munisel['INE']] =  $munisel['MUNICIPIO'];
}
mysqli_free_result($res_selmuni);
// Select de Organizaciones
$sql_selorg = "SELECT ID, ORGANIZACION FROM organizaciones ORDER BY organizaciones.ORGANIZACION ASC";
$res_selorg = mysqli_query($link, $sql_selorg) or die($errsqlselorg . ": " . mysqli_error($link));
$nselorg = mysqli_num_rows($res_selorg);
// Construimos el Select de Organizaciones:
$selorg = array();
while ($orgsel = mysqli_fetch_assoc($res_selorg)){
    $selorg[$orgsel['ID']] = $orgsel['ORGANIZACION'];
}
mysqli_free_result($res_selorg);
?>
