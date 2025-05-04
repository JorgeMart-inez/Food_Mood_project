<?php
//LIBRERIA AUXILIAR
namespace mi_libreria;

class util{

    public static function calc_costo_servicios($pServicios){
        $precio_servicio = [
            "1"  => 1000,
            "2"  => 500,
            "3"  => 2500, 
            "4"  => 4000,
            "5"  => 2500,
        ];
    
        $costo_total = 0;
    
        foreach($pServicios as $servicio){
            if(isset($precio_servicio[$servicio])){
                $costo_total += $precio_servicio[$servicio];
            }
        }
    
        return $costo_total + 20000; //20000 es el precio base de cada paquete
    }

}
?>