<?php
require_once '../libreria/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_POST['html'])) {
    $html = $_POST['html'];

    // Cargar el contenido del archivo CSS como string
    $css = file_get_contents('../css/estilos_libreria.css');

    // Envolver el HTML original con head, estilos y estructura completa
    $html_final = "
        <html>
        <head>
            <style>
                $css
            </style>
        </head>
        <body>
            $html
        </body>
        </html>
    ";

    $options = new Options();
    $options->set('defaultFont', 'Helvetica');
    $options->setIsHtml5ParserEnabled(true); // Asegura compatibilidad con HTML5
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html_final);

    // Tamaño y orientación (A4 y horizontal)
    $dompdf->setPaper('A4', 'landscape');

    $dompdf->render();

    // Forzar descarga
    $dompdf->stream("cotizacion.pdf", ["Attachment" => true]);
}
?>
