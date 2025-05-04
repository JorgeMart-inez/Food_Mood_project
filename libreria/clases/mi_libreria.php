<?php
//LIBRERIA PRINCIPAL
namespace mi_libreria;

require_once __DIR__ . "/util.php";
require_once __DIR__ . '/../fpdf/fpdf.php';

use DateTime;
use FPDF;
use mi_libreria\util;

class PDF extends FPDF{
       public function formato_pdf1($pPaquete, $pNombre, $pEvento, $pLugar, $pFecha, $pHora,$pDuracion, $pInvitados, $pServicios_str, 
       $pAperitivo, $pEntrada, $pPlato, $pBebida, $pMetodo, $pServicios) 
       {
              $cost_invit = $pInvitados * 650;                        
              $total      = util::calc_costo_servicios($pServicios) + $cost_invit; // Llamamos a la funcion auxiliar para calcular el costo
              $referencia = strtoupper(substr(md5($pNombre . $pEvento . $pFecha), 0, 10));  // Generamos una referencia de pago única   

              // Crear PDF
              $pdf = new FPDF();
              $pdf->AddPage();
              $pdf->SetFont('Arial', 'B', 16);
              $pdf->Cell(0, 10, "FORMATO DE PAGO - $pPaquete", 0, 1, 'C');

              $pdf->SetFont('Arial', '', 12);
              $pdf->Cell(50, 10, "Anfitrión: $pNombre", 0, 1);
              $pdf->Cell(50, 10, "Tipo de Evento: $pEvento", 0, 1);
              $pdf->Cell(50, 10, "Lugar del Evento: $pLugar", 0, 1);
              $pdf->Cell(50, 10, "Fecha: $pFecha", 0, 1);
              $pdf->Cell(50, 10, "Hora: $pHora", 0, 1);
              $pdf->Cell(50, 10, "Duración: $pDuracion Horas", 0, 1);
              $pdf->Cell(50, 10, "Invitados: $pInvitados personas", 0, 1);
              $pdf->Cell(50, 10, "Servicios: $pServicios_str", 0, 1);
              $pdf->Cell(50, 10, "Aperitivo: $pAperitivo", 0, 1);
              $pdf->Cell(50, 10, "Entrada: $pEntrada", 0, 1);
              $pdf->Cell(50, 10, "Plato Fuerte: $pPlato", 0, 1);
              $pdf->Cell(50, 10, "Bebida: $pBebida", 0, 1);
              $pdf->Cell(50, 10, "Método de Pago: $pMetodo", 0, 1);
              $pdf->Cell(50, 10, "Total a Pagar: $total", 0, 1);
              $pdf->Cell(50, 10, "Referencia de Pago: $referencia", 0, 1);

              $pdf->Output('I', 'formato_pago_' . $referencia . '.pdf');
       }

       /* Formato para paquete 3 y 4 */
       public function formato_pdf2($pPaquete, $pNombre, $pEvento, $pLugar, $pFecha, $pHora, $pDuracion, $pInvitados, $pServicios_str, 
              $pAperitivo, $pEntrada, $pPlato, $pPostre , $pBebida, $pMetodo, $pServicios) 
       {
              $cost_invit = $pInvitados * 700;                        
              $total      = util::calc_costo_servicios($pServicios) + $cost_invit; // Llamamos a la funcion auxiliar para calcular el costo
              $referencia = strtoupper(substr(md5($pNombre . $pEvento . $pFecha), 0, 10));  // Generamos una referencia de pago única   

              // Crear PDF
              $pdf = new FPDF();
              $pdf->AddPage();
              $pdf->SetFont('Arial', 'B', 16);
              $pdf->Cell(0, 10, "FORMATO DE PAGO - $pPaquete", 0, 1, 'C');

              $pdf->SetFont('Arial', '', 12);
              $pdf->Cell(50, 10, "Anfitrión: $pNombre", 0, 1);
              $pdf->Cell(50, 10, "Tipo de Evento: $pEvento", 0, 1);
              $pdf->Cell(50, 10, "Lugar del Evento: $pLugar", 0, 1);
              $pdf->Cell(50, 10, "Fecha: $pFecha", 0, 1);
              $pdf->Cell(50, 10, "Hora: $pHora", 0, 1);
              $pdf->Cell(50, 10, "Duración: $pDuracion Horas", 0, 1);
              $pdf->Cell(50, 10, "Invitados: $pInvitados personas", 0, 1);
              $pdf->Cell(50, 10, "Servicios: $pServicios_str", 0, 1);
              $pdf->Cell(50, 10, "Aperitivo: $pAperitivo", 0, 1);
              $pdf->Cell(50, 10, "Entrada: $pEntrada", 0, 1);
              $pdf->Cell(50, 10, "Plato Fuerte: $pPlato", 0, 1);
              $pdf->Cell(50, 10, "Postre: $pPostre", 0, 1);
              $pdf->Cell(50, 10, "Bebida: $pBebida", 0, 1);
              $pdf->Cell(50, 10, "Método de Pago: $pMetodo", 0, 1);
              $pdf->Cell(50, 10, "Total a Pagar: $total", 0, 1);
              $pdf->Cell(50, 10, "Referencia de Pago: $referencia", 0, 1);

              // Salida del PDF al navegador
              $pdf->Output('I', 'formato_pago_' . $referencia . '.pdf');
       }
}

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
    public function formato_cotizar($pPaquete,$pNombre, $pEvento, $pLugar, $pFecha, $pHora,
                            $pDuracion, $pInvitados, $pServicios_str, $pAperitivo, 
                            $pEntrada, $pPlato, $pBebida, $pMetodo, $pServicios)
       {
              $cost_invit = $pInvitados * 650;                        
              $total      = util::calc_costo_servicios($pServicios) + $cost_invit;//Llamamos a la funcion auxiliar pra calcular el costo
              $referencia = strtoupper(substr(md5($pNombre . $pEvento . $pFecha), 0, 10));  // Generamos una referencia de pago única                   
              print "<h1 align='center'>FORMATO DE PAGO - $pPaquete </h1><br>";
              print "<table border='3' align='center' width='1000px' height='450px'  style='table-layout: fixed;'>";
              print "<tr> 
                     <th style='width: 33%;'>ANFITRIÓN:</th> 
                     <th style='width: 33%;'>TIPO DE EVENTO:</th>
                     <th style='width: 33%;'>LUGAR DEL EVENTO:</th>
              </tr>";
              print "<tr> 
                     <td align='center' style='width: 33%;'>$pNombre</td> 
                     <td align='center' style='width: 33%;'>$pEvento</td> 
                     <td align='center' style='width: 33%;'>$pLugar</td>
              </tr>";
              print "<tr> 
                     <th colspan='2' align='center'>FECHA:</th> 
                     <th colspan='1' align='center'>HORA:</th>
              </tr>";
              print "<tr> 
                     <td align='center' colspan='2'>$pFecha</td> 
                     <td align='center' colspan='1'>$pHora hrs.</td>
              </tr>";
              print "<tr>
                     <th align='center' colspan='1'>Duracion del evento:</th> 
                     <th align='center' colspan='2'>Invitados:</th>
                     </tr>";
              print "<tr> 
                     <td align='center' colspan='1'>$pDuracion Horas</td> 
                     <td align='center' colspan='2'>$pInvitados personas</td>  
                     </tr>";
              print "<tr>
                     <th colspan='3' align='center'>Servicios:</th>
                     </tr>";
              print  "<tr>
                     <td colspan='3' align='center'>$pServicios_str</td>
                     </tr>"; 
              print "<tr>
                     <th style='width: 33%;'>Aperitivo:</th> 
                     <th style='width: 33%;'>Entrada:</th>
                     <th style='width: 33%;'>Plato fuerte:</th>
                     </tr>";
              print "<tr> 
                     <td align='center' style='width:33%;'>$pAperitivo</td> 
                     <td align='center' style='width:33%;'>$pEntrada</td>
                     <td align='center' style='width:33%;'>$pPlato</td>
                     </tr>";
              print "<tr>
                     <th colspan='3' align='center'>Bebida:</th>
                     </tr>";
              print "<tr> 
                     <td colspan='3' align='center'>$pBebida</td>
                     </tr>";
              print "<tr>
                     <th align='center' colspan='1'>Método de Pago(tarjeta):</th>
                     <th align='center' colspan='2'>Total a pagar:</th>
                     </tr>";
              print "<tr> 
                     <td align='center' colspan='1'>$pMetodo</td>
                     <td align='center' colspan='2'>$total</td>   
                     </tr>";
              print "<tr>
                     <th style='width: 33%;'>Referencia de pago:</th>
                     <td colspan='2' align='center'>$referencia</td>
              </tr>";                   	
              print "</table>";
       }

     /* Formato para paquete 3 y 4 */
public function formato_cotizar2($pPaquete,$pNombre, $pEvento, $pLugar, $pFecha, $pHora,
                            $pDuracion, $pInvitados, $pServicios_str, $pAperitivo, 
                            $pEntrada, $pPlato, $pPostre , $pBebida, $pMetodo, $pServicios)
       {
              $cost_invit = $pInvitados * 700;                        
              $total      = util::calc_costo_servicios($pServicios) + $cost_invit;//Llamamos a la funcion auxiliar pra calcular el costo
              $referencia = strtoupper(substr(md5($pNombre . $pEvento . $pFecha), 0, 10));  // Generamos una referencia de pago única                   
              print "<h1 align='center'>FORMATO DE PAGO - $pPaquete </h1><br>";
              print "<table border='3' align='center' width='1000px' height='450px'  style='table-layout: fixed;'>";
              print "<tr> 
                     <th style='width: 33%;'>ANFITRIÓN:</th> 
                     <th style='width: 33%;'>TIPO DE EVENTO:</th>
                     <th style='width: 33%;'>LUGAR DEL EVENTO:</th>
              </tr>";
              print "<tr> 
                     <td align='center' style='width: 33%;'>$pNombre</td> 
                     <td align='center' style='width: 33%;'>$pEvento</td> 
                     <td align='center' style='width: 33%;'>$pLugar</td>
              </tr>";
              print "<tr> 
                     <th colspan='2' align='center'>FECHA:</th> 
                     <th colspan='1' align='center'>HORA:</th>
              </tr>";
              print "<tr> 
                     <td align='center' colspan='2'>$pFecha</td> 
                     <td align='center' colspan='1'>$pHora hrs.</td>
              </tr>";
              print "<tr>
                     <th align='center' colspan='1'>Duracion del evento:</th> 
                     <th align='center' colspan='2'>Invitados:</th>
                     </tr>";
              print "<tr> 
                     <td align='center' colspan='1'>$pDuracion Horas</td> 
                     <td align='center' colspan='2'>$pInvitados personas</td>  
                     </tr>";
              print "<tr>
                     <th colspan='3' align='center'>Servicios:</th>
                     </tr>";
              print  "<tr>
                     <td colspan='3' align='center'>$pServicios_str</td>
                     </tr>"; 
              print "<tr>
                     <th style='width: 33%;'>Aperitivo:</th> 
                     <th style='width: 33%;'>Entrada:</th>
                     <th style='width: 33%;'>Plato fuerte:</th>
                     </tr>";
              print "<tr> 
                     <td align='center' style='width:33%;'>$pAperitivo</td> 
                     <td align='center' style='width:33%;'>$pEntrada</td>
                     <td align='center' style='width:33%;'>$pPlato</td>
                     </tr>";
              print "<tr>
                     <th colspan='1' align='center'>Bebida:</th>
                     <th colspan='2' align='center'>Postre:</th>
                     </tr>";
              print "<tr> 
                     <td colspan='1' align='center'>$pBebida</td>
                     <td colspan='2' align='center'>$pPostre</td>
                     </tr>";
              print "<tr>
                     <th align='center' colspan='1'>Método de Pago(trajeta):</th>
                     <th align='center' colspan='2'>Total a pagar:</th>
                     </tr>";
              print "<tr> 
                     <td align='center' colspan='1'>$pMetodo</td>
                     <td align='center' colspan='2'>$total</td>   
                     </tr>";
              print "<tr>
                     <th style='width: 33%;'>Referencia de pago:</th>
                     <td colspan='2' align='center'>$referencia</td>
              </tr>";                   	
              print "</table>";   
       }
}
?>