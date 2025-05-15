<?php
//LIBRERIA PRINCIPAL
namespace mi_libreria;

require_once __DIR__ . "/util.php";

use DateTime;
use mi_libreria\util;

echo "<link rel='stylesheet' href='../css/estilos_libreria.css'>";
class mi_libreria{

       public function referencia_pago($pNombre, $pEvento, $pFecha)
       {
              return strtoupper(substr(md5($pNombre . $pEvento . $pFecha), 0, 10));
       }

       function obtenerFecha() 
       {
              $fechas = [];
              $hoy = new DateTime(); // Fecha actual

              for ($i = 0; $i <= 5; $i++) {
                     $fecha = clone $hoy; // Clonamos el objeto para no modificar el original
                     $fecha->modify("+$i day");
                     $fechas[] = $fecha->format('Y-m-d'); // Puedes cambiar el formato si deseas
              }
       
              return $fechas;
       }

       /* Formato para paquete 1 y 2 */
       public function formato_cotizar($pPaquete, $pAnfitrion, $pEvento, $pLugar, $pFecha, $pHora, $pDuracion, 
              $pInvitados, $pServicios_str, $pAperitivo, $pEntrada, $pPlato, $pBebida, $pMetodo, $pServicios)
       {
              $cost_invit = $pInvitados * 650;                        
              $total      = util::calc_costo_servicios($pServicios) + $cost_invit;
              $referencia = strtoupper(substr(md5($pAnfitrion . $pEvento . $pFecha), 0, 10));

              $html  = "<h1 class='titulo-cotizacion'>FORMATO DE PAGO - $pPaquete</h1>";
              $html .= "<table class='tabla-cotizacion'>";
              $html .= "<tr><th>ANFITRIÓN:</th><th>TIPO DE EVENTO:</th><th>LUGAR DEL EVENTO:</th></tr>";
              $html .= "<tr><td>$pAnfitrion</td><td>$pEvento</td><td>$pLugar</td></tr>";
              $html .= "<tr><th colspan='2'>FECHA:</th><th>HORA:</th></tr>";
              $html .= "<tr><td colspan='2'>$pFecha</td><td>$pHora hrs.</td></tr>";
              $html .= "<tr><th>Duración del evento:</th><th colspan='2'>Invitados:</th></tr>";
              $html .= "<tr><td>$pDuracion Horas</td><td colspan='2'>$pInvitados personas</td></tr>";
              $html .= "<tr><th colspan='3'>Servicios:</th></tr>";
              $html .= "<tr><td colspan='3'>$pServicios_str</td></tr>";
              $html .= "<tr><th>Aperitivo:</th><th>Entrada:</th><th>Plato fuerte:</th></tr>";
              $html .= "<tr><td>$pAperitivo</td><td>$pEntrada</td><td>$pPlato</td></tr>";
              $html .= "<tr><th colspan='3'>Bebida:</th></tr>";
              $html .= "<tr><td colspan='3'>$pBebida</td></tr>";
              $html .= "<tr><th>Método de Pago:</th><th colspan='2'>Total a pagar:</th></tr>";
              $html .= "<tr><td>$pMetodo</td><td colspan='2'>$$total.00</td></tr>";
              $html .= "<tr><th>Referencia de pago:</th><td colspan='2'>$referencia</td></tr>";                  
              $html .= "</table>";
              $html .= "<div class='acciones-cotizacion'>";
              $html .= "<form method='post' action='generar_pdf.php'>";
              $html .= "<input type='hidden' name='html' value='" . htmlspecialchars($html) . "'/>";
              $html .= "<button type='submit' class='btn-pdf'>Convertir a PDF</button>";
              $html .= "</form>";
              $html .= "<a href='../index.php' class='btn-regresar'>Regresar al inicio</a>";
              $html .= "</div>";

              echo $html;
       }

       public function formato_cotizar2($pPaquete, $pAnfitrion, $pEvento, $pLugar, $pFecha, $pHora,
                                          $pDuracion, $pInvitados, $pServicios_str, $pAperitivo, 
                                          $pEntrada, $pPlato, $pPostre , $pBebida, $pMetodo, $pServicios)
       {
              $cost_invit = $pInvitados * 700;                        
              $total = util::calc_costo_servicios($pServicios) + $cost_invit;
              $referencia = strtoupper(substr(md5($pAnfitrion . $pEvento . $pFecha), 0, 10));

              $html = "<h1 class='titulo-cotizacion'>FORMATO DE PAGO - $pPaquete </h1><br>";
              $html .= "<table class='tabla-cotizacion'>";
              $html .= "<tr><th>ANFITRIÓN:</th><th>TIPO DE EVENTO:</th><th>LUGAR DEL EVENTO:</th></tr>";
              $html .= "<tr><td>$pAnfitrion</td><td>$pEvento</td><td>$pLugar</td></tr>";
              $html .= "<tr><th colspan='2'>FECHA:</th><th>HORA:</th></tr>";
              $html .= "<tr><td colspan='2'>$pFecha</td><td>$pHora hrs.</td></tr>";
              $html .= "<tr><th>Duración del evento:</th><th colspan='2'>Invitados:</th></tr>";
              $html .= "<tr><td>$pDuracion Horas</td><td colspan='2'>$pInvitados personas</td></tr>";
              $html .= "<tr><th colspan='3'>Servicios:</th></tr>";
              $html .= "<tr><td colspan='3'>$pServicios_str</td></tr>";
              $html .= "<tr><th>Aperitivo:</th><th>Entrada:</th><th>Plato fuerte:</th></tr>";
              $html .= "<tr><td>$pAperitivo</td><td>$pEntrada</td><td>$pPlato</td></tr>";
              $html .= "<tr><th>Bebida:</th><th colspan='2'>Postre:</th></tr>";
              $html .= "<tr><td>$pBebida</td><td colspan='2'>$pPostre</td></tr>";
              $html .= "<tr><th>Método de Pago:</th><th colspan='2'>Total a pagar:</th></tr>";
              $html .= "<tr><td>$pMetodo</td><td colspan='2'>$$total.00</td></tr>";
              $html .= "<tr><th>Referencia de pago:</th><td colspan='2'>$referencia</td></tr>";
              $html .= "</table>";
              $html .= "<div class='acciones-cotizacion'>";
              $html .= "<form method='post' action='generar_pdf.php'>";
              $html .= "<input type='hidden' name='html' value='" . htmlspecialchars($html) . "'/>";
              $html .= "<button type='submit' class='btn-pdf'>Convertir a PDF</button>";
              $html .= "</form>";
              $html .= "<a href='../index.php' class='btn-regresar'>Regresar al inicio</a>";
              $html .= "</div>";

              echo $html;
       }

}


?>