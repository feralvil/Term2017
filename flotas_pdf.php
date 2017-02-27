<?php
// Obtenemos el fichero de idioma
require_once 'idioma.php';
$lang = "idioma/flotas_$idioma.php";
require_once $lang;

// Conexión a la BBDD:
require_once 'conectabbdd.php';

// Obtención del usuario
require_once 'autenticacion.php';

// Clases para generar el Excel
/** Error reporting */
error_reporting(E_ALL);
date_default_timezone_set('Europe/Madrid');

/** Clases TCPDF */
require_once 'export/tcpdf/tcpdf.php';

// Extender la clase TCPDF para crear una cabecera y un pie de página propios
class MYPDF extends TCPDF {
    var $pagina = "";
    var $titulo = "";

    //Cabecera
    public function Header() {
        // Logo
        $this->Image('img/comdes2.png', 20, 5, 30);
        // Establecemos la fuente y colores
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('helvetica', 'B', 12);
        // Nos desplazamos a a la derecha
        $this->Cell(20);

        // Espacio en Blanco: Determinamos si es página Vertical u Horizontal
        $ancho = 130;
        if ($this->CurOrientation == "L"){
            $ancho = 210;
        }
        $this->Cell($ancho, 10, $this->titulo, 0, 0, 'C');

        // Logo 2
        $this->Image('img/logo_chap.png', '', '', 40);
        // Salto de línea
        $this->Ln();
        $this->Cell(0, 0, '', 'T');
    }

    // Pie de página
    public function Footer() {
        // Posición at 1.5 cm del fin de página
        $this->SetY(-15);
        // Establecemos la fuente y colores
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('helvetica', 'B', 8);
        // Número de Página
        $this->Cell(0, 10, $this->pagina . ' ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 'T', 0, 'C');
    }
}

// crear nuevo documento
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Información de documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Oficina COMDES');
$pdf->SetTitle($titulo);
$pdf->SetSubject($titulo);
$pdf->SetKeywords('COMDES, Flota');

// Márgenes
$pdf->SetMargins(15, 20, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


// Salto automático de página
$pdf->SetAutoPageBreak(TRUE, 15);

// Factor de Escala de las imágenes
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Establecemos la fuente por defecto
$pdf->SetFont('helvetica', '', 8);
// Título
$pdf->titulo = $titulo;
$pdf->pagina = $txtpagina;
// Añadir una página
$pdf->AddPage();

// Permisos de Usuario:
$permiso = 0;
if ($flota_usu == 100) {
    $permiso = 2;
}

if ($permiso > 1){
    // Consultas a la BBDD
    require_once 'sql_flotasexp.php';
    ini_set('memory_limit', "64M");

    // Cabecera:
    $h1txt = '<h1>' . $h1 . '</h1>';
    $pdf->writeHTML($h1txt, true, true, true, false, '');
    $pdf->Ln(5);

    // Número de flotas:
    $h2result = '<h2>' . $txtresult . ': ' . $nflotas . ' ' . $txtnomfichero . '</h2>';
    $pdf->writeHTML($h2result, true, true, true, false, '');
    $pdf->Ln(5);

    //Criterios de selección:
    $ncrit = 0;
    $h3crit = '<h3>' . $txtcriterios . '</h3>';
    $h3crit .= '<ul>';
    if ((isset($_POST['idorg']))&&($_POST['idorg'] > 0)){
        $h3crit .= '<li><strong>' . $txtorg . '</strong>: ' . $selorg['ORGANIZACION'] . '</li>';
        $ncrit++;
    }
    if ($idflota > 0){
        $h3crit .= '<li><strong>Flota</strong>: ' .  $selflota['FLOTA'] . '</li>';
        $ncrit++;
    }
    if ((isset($_POST['formcont']))&&($_POST['formcont'] != "")){
        $valcont = array('SI' => 'Sí', 'NO' => 'NO');
        $h3crit .= '<li><strong>' . $txtcontof . '</strong>: ' . $valcont[$_POST['formcont']] . '</li>';
        $ncrit++;
    }
    $h3crit .= '</ul>';
    if ($ncrit > 0){
        $pdf->writeHTML($h3crit, true, true, true, false, '');
        $pdf->Ln(5);
    }

    // Tabla con las flotas:
    $tablaflotas = <<<THEAD
        <table style="width:100%;" border="1">
            <thead>
                <tr style="background-color:#EEEEEE";>
                    <th style="font-weight:bold;text-align:center;width:10mm;">ID</th>
                    <th style="font-weight:bold;text-align:center;width:45mm;">$txtorg</th>
                    <th style="font-weight:bold;text-align:center;width:55mm;">Flota</th>
                    <th style="font-weight:bold;text-align:center;width:30mm;">$thacronimo</th>
                    <th style="font-weight:bold;text-align:center;width:20mm;">$thencripta</th>
                    <th style="font-weight:bold;text-align:center;width:30mm;">$thnterm</th>
                    <th style="font-weight:bold;text-align:center;width:20mm;">$thtbase</th>
                    <th style="font-weight:bold;text-align:center;width:20mm;">$thtmov</th>
                    <th style="font-weight:bold;text-align:center;width:20mm;">$thtport</th>
                    <th style="font-weight:bold;text-align:center;width:20mm;">$thtdesp</th>
                </tr>
            </thead>
THEAD;

    $relleno = false;
    foreach ($flotas as $flota) {
        if ($relleno){
            $tablaflotas .= '<tr style="background-color:#EEEEEE";>';
        }
        else{
            $tablaflotas .= '<tr>';
        }
        $tablaflotas .= '<td style="text-align:center;width:10mm;">' . $flota['ID'] . '</td>';
        $tablaflotas .= '<td style="width:45mm;">' . $flota['ORGANIZACION'] . '</td>';
        $tablaflotas .= '<td style="width:55mm;">' . $flota['FLOTA'] . '</td>';
        $tablaflotas .= '<td style="width:30mm;">' . $flota['ACRONIMO'] . '</td>';
        $tablaflotas .= '<td style="text-align:center;width:20mm;">' . $flota['ENCRIPTACION'] . '</td>';
        $tablaflotas .= '<td style="text-align:right;width:30mm;">' . $flota['NTERM'] . '</td>';
        $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $flota['NBASE'] . '</td>';
        $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $flota['NMOV'] . '</td>';
        $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $flota['NPORT'] . '</td>';
        $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $flota['NDESP'] . '</td>';
        $tablaflotas .= '</tr>';
        $relleno = !($relleno);
    }
    if ($relleno){
        $tablaflotas .= '<tr style="background-color:#EEEEEE";>';
    }
    else{
        $tablaflotas .= '<tr>';
    }
    $tablaflotas .= '<td style="font-weight:bold;text-align:center;" colspan="5">' . $txttotales . '</td>';
    $tablaflotas .= '<td style="text-align:right;width:30mm;">' . $totterm[0] . '</td>';
    $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $totterm[1] . '</td>';
    $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $totterm[2] . '</td>';
    $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $totterm[3] . '</td>';
    $tablaflotas .= '<td style="text-align:right;width:20mm;">' . $totterm[4] . '</td>';
    $tablaflotas .= '</tr>';
    $tablaflotas .= "</table>";
    $pdf->writeHTML($tablaflotas, true, true, true, false, '');

}
else{
    $h1txt = '<h1>' . $h3perm . '</h1>';
    $h1txt .=  '<p style="color:#FF0000;">' . $errnoperm . '</p>';
    $pdf->writeHTML($h1txt, true, true, true, false, '');
    $pdf->Ln(5);

}


// Generamos el PDF:
$nomFichero = $txtnomfichero . "_COMDES.pdf";
$pdf->Output($nomFichero, 'I');
?>
