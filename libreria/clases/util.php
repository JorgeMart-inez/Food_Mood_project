<?php
//LIBRERIA AUXILIAR
namespace mi_libreria;

class util{

    public static function calc_costo_servicios($pServicios){
        $precio_servicio = [
            "cristaleria" => 1000,
            "manteleria"  => 500,
            "meseros"     => 2500, 
            "musica"      => 4000,
            "decoracion"  => 2500,
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