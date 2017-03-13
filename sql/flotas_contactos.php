<?php
// Fijamos la Flota si es un usuario restringido o si se ha elegido una
$idflota = 0;
if (isset($_POST['idflota'])){
    $idflota = $_POST['idflota'];
}
else{
    $idflota = $flota_usu;
}

// Consulta de tabla de flotas
$sql_flota = "SELECT flotas.FLOTA, flotas.ACRONIMO, organizaciones.ORGANIZACION FROM flotas, organizaciones";
$sql_flota .= " WHERE (flotas.ID = $idflota) AND (organizaciones.ID = flotas.ORGANIZACION)";
$res_flota = mysqli_query($link, $sql_flota) or die($errsqlflota . ': ' . mysqli_error($link));
$nflota = mysqli_num_rows($res_flota);
if ($nflota > 0){
    $flota = mysqli_fetch_assoc($res_flota);
    mysqli_free_result($res_flota);
    // CONTACTOS DE FLOTAS:
    $sql_contflota = "SELECT * FROM contactos_flotas WHERE (FLOTA_ID = $idflota) ORDER BY ROL ASC, ORDEN ASC";
    $res_contflota = mysqli_query($link, $sql_contflota) or die($errsqlcontflota . ': ' . mysqli_error($link));
    $ncontflota = mysqli_num_rows($res_contflota);
    $idcont = array();
    if ($ncontflota > 0){
        for ($i = 0; $i < $ncontflota; $i++){
            $contflota = mysqli_fetch_assoc($res_contflota);
            $idcont[$contflota['ROL']][$contflota['ORDEN']] = $contflota['CONTACTO_ID'];
        }
        mysqli_free_result($res_contflota);
        $contactos = array();
        $contunicos = array();
        foreach ($idcont as $rol => $arraycont) {
            foreach ($arraycont as $orden => $idcontacto) {
                if (array_key_exists($idcontacto, $contunicos)){
                    $contacto = $contunicos[$idcontacto];
                }
                else{
                    $sql_contacto = "SELECT * FROM contactos WHERE (ID = $idcontacto)";
                    $res_contacto = mysqli_query($link, $sql_contacto) or die($errsqlcontacto . ': ' . mysqli_error($link));
                    $ncontacto = mysqli_num_rows($res_contacto);
                    if ($ncontacto > 0){
                        $contacto = mysqli_fetch_assoc($res_contacto);
                        $contunicos[$idcontacto] = $contacto;
                    }
                }
                $contactos[$rol][$orden] = $contacto;
            }
        }
        mysqli_free_result($res_contacto);
    }
}
?>
