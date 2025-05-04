<?php

include('conndb.php');
require_once __DIR__ . '/../libreria/includes/autoload.php';
use mi_libreria\util;
use mi_libreria\PDF;

$pdf = new PDF();
$libreria_aux = new util();

if(isset($_POST['cotizar-p1']))
{
        //Variables recibidas del formulario
        $anfitrion = trim($_POST['anfitrion']);
        $fecha     = trim($_POST['fecha']);
        $lugar     = trim($_POST['lugar']);
        $hora      = trim($_POST['hora']);
        $duracion  = ($_POST['duracion']);
        $invitados = ($_POST['invitados']);
        $evento    = trim($_POST['tipo_evento']);
        $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : [];
        $aperitivo = trim($_POST['aperitivo']);
        $entrada   = trim($_POST['entrada']);
        $plato     = trim($_POST['plato_fuerte']);
        $postre    = 'No incluido';
        $bebida    = trim($_POST['bebida']);
        $metodo    = trim($_POST['metodo_pago']);
        $servicios_str = implode(", ", $servicios); 

        //constantes declaradas segun el paquete
        $paquete   = 'PAQUETE UNO';
        $invitados = 50;

        $costo_servicios = $libreria_aux->calc_costo_servicios($servicios);
        $costo_total     = $costo_servicios + ($invitados * 650);

        
        
        $pdf->formato_pdf1($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                        $invitados, $servicios_str, $aperitivo, $entrada, $plato, $bebida, $metodo, $servicios);
        
        $pdf->Output('I', 'cotizacion.pdf');
        $pdf->Close();
}

?>