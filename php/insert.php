<?php

session_start();
include('conndb.php');
require_once __DIR__ . '/../libreria/includes/autoload.php';
use mi_libreria\util;   
use mi_libreria\mi_libreria;
$libreria = new mi_libreria();
$libreria_aux = new util();


if (isset($_POST['cotizar-p1'])) {
    try {
        $conn->beginTransaction();
 
        //Variables recibidas del formulario
        $anfitrion = trim($_POST['anfitrion']); 
        $fecha     = trim($_POST['fecha']); 
        $lugar     = trim($_POST['lugar']); 
        $hora      = trim($_POST['hora']); 
        $duracion  = !empty($_POST['duracion']); 
        $invitados = !empty($_POST['invitados']); 
        $evento    = trim($_POST['tipo_evento']); 
        $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : []; 
        $aperitivo = !empty($_POST['aperitivo']);
        $entrada   = !empty($_POST['entrada']);
        $plato     = !empty($_POST['plato_fuerte']);
        $postre    = null;
        $bebida    = !empty($_POST['bebida']);
        $metodo    = !empty($_POST['metodo_pago']); 
        $paquete   = 'PAQUETE SENCILLO'; 
        $invitados = 50;
        $costo_servicios = $libreria_aux->calc_costo_servicios($servicios);
        $costo_total     = $costo_servicios + ($invitados * 650);
        $referencia_pago = $libreria->referencia_pago($paquete, $evento, $fecha);

        $stmt = $conn->prepare("INSERT INTO evento(fecha_evento, lugar_evento, hora_evento, duracion_evento,
                                cantidad_invitados, tipo_evento) 
                                        VALUES (:fecha, :lugar, :hora, :duracion, :invitados, :tipo_evento)");
        $stmt->bindParam(':fecha'       , $fecha        , PDO::PARAM_STR);
        $stmt->bindParam(':lugar'       , $lugar        , PDO::PARAM_STR);
        $stmt->bindParam(':hora'        , $hora         , PDO::PARAM_STR);
        $stmt->bindParam(':duracion'    , $duracion     , PDO::PARAM_INT);
        $stmt->bindParam(':invitados'   , $invitados    , PDO::PARAM_INT);
        $stmt->bindParam(':tipo_evento' , $evento       , PDO::PARAM_STR);
        $ok1 = $stmt->execute();
        $id_evento = $conn->lastInsertId();

        $stmt2 = $conn->prepare("INSERT INTO paquete(nombre_paquete, anfitrion, fk_evento, fk_aperitivo, 
                                fk_entrada, fk_plato_fuerte, fk_postre, fk_bebida, fk_metodo_pago) 
                                VALUES (:paquete, :anfitrion, :evento, :aperitivo, :entrada, :plato_fuerte, 
                                :postre, :bebida, :metodo_pago)");

        $stmt2->bindParam(':paquete'     , $paquete      , PDO::PARAM_STR);
        $stmt2->bindParam(':anfitrion'   , $anfitrion    , PDO::PARAM_STR);
        $stmt2->bindParam(':evento'      , $id_evento    , PDO::PARAM_INT);
        $stmt2->bindParam(':aperitivo'   , $aperitivo    , PDO::PARAM_STR);
        $stmt2->bindParam(':entrada'     , $entrada      , PDO::PARAM_STR);
        $stmt2->bindParam(':plato_fuerte', $plato        , PDO::PARAM_STR);
        $stmt2->bindParam(':postre'      , $postre       , PDO::PARAM_STR);
        $stmt2->bindParam(':bebida'      , $bebida       , PDO::PARAM_STR);
        $stmt2->bindParam(':metodo_pago' , $metodo       , PDO::PARAM_STR);
        $ok2 = $stmt2->execute();
        $id_paquete = $conn->lastInsertId();

        $id_cliente = $_SESSION['id_usuario']; // Obtenemos el id_usuario de la sesión
        $id_usuario = $id_cliente;

        if(!empty($_POST['servicios']))
        {
            $servicios = $_POST['servicios'];
            
            $ok3 = true;
            foreach($servicios as $servicio)
            {
                $stmt3 = $conn->prepare("INSERT INTO paquete_servicio(fk_paquete, fk_servicio, fk_cliente)
                                            VALUES (:id_paquete, :id_servicio, :id_cliente)");
                $stmt3->bindValue(':id_paquete' , $id_paquete , PDO::PARAM_INT);
                $stmt3->bindValue(':id_servicio' , $servicio  , PDO::PARAM_INT);
                $stmt3->bindValue(':id_cliente'  , $id_cliente , PDO::PARAM_INT);
                $ok3 = $ok3 && $stmt3->execute();
            }
        }
        
        $stmt4 = $conn->prepare("INSERT INTO cotizacion(fk_paquete, fk_cliente, fk_evento, total) 
                                            VALUES (:id_paquete, :id_cliente, :id_evento, :total_costo)");
        $stmt4->bindParam(':id_paquete' , $id_paquete , PDO::PARAM_INT);
        $stmt4->bindParam(':id_cliente' , $id_cliente , PDO::PARAM_INT);
        $stmt4->bindParam(':id_evento'  , $id_evento  , PDO::PARAM_INT);
        $stmt4->bindParam(':total_costo', $costo_total, PDO::PARAM_INT);
        $ok4 = $stmt4->execute();
        $id_cotizacion = $conn->lastInsertId();

        $fecha_pago = $libreria->obtenerFecha()[5];
        $estado_pago = 'Pendiente'; 
        $stmt5 = $conn->prepare("INSERT INTO datos_pago(referencia_pago, fk_metodo_pago, estado_pago, 
                                        fecha_pago, fk_cliente, fk_usuario) 
                                        VALUES (:referencia_pago, :metodo_pago, :estado_pago, :fecha_pago, 
                                                :id_cliente, :id_usuario)");
        $stmt5->bindParam(':referencia_pago', $referencia_pago, PDO::PARAM_INT);
        $stmt5->bindParam(':metodo_pago'    , $metodo         , PDO::PARAM_STR);
        $stmt5->bindParam(':estado_pago'    , $estado_pago    , PDO::PARAM_STR);
        $stmt5->bindParam(':fecha_pago'     , $fecha_pago     , PDO::PARAM_STR);
        $stmt5->bindParam(':id_cliente'     , $id_cliente     , PDO::PARAM_INT);
        $stmt5->bindParam(':id_usuario'     , $id_usuario     , PDO::PARAM_INT);
        $ok5 = $stmt5->execute();
        $id_datos_pago = $conn->lastInsertId();

        $stmt6 = $conn->prepare("INSERT INTO pago(fk_paquete , fk_cotizacion, fk_cliente, fk_datos_pago) 
                                        VALUES (:id_paquete, :id_cotizacion, :id_cliente, :id_datos_pago)");
        $stmt6->bindParam(':id_paquete'   , $id_paquete    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cotizacion' , $id_cotizacion , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cliente'   , $id_cliente    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_datos_pago', $id_datos_pago , PDO::PARAM_INT);
        $ok6 = $stmt6->execute();

        //Obteniendo el nombre de las opciones seleccionadas
        $stmt_select1 = $conn->prepare("SELECT nombre_aperitivo FROM aperitivos WHERE id_aperitivo = :id_aperitivo");
        $stmt_select1->bindParam(':id_aperitivo', $aperitivo, PDO::PARAM_INT);
        $stmt_select1->execute();
        $nombre_aperitivo = $stmt_select1->fetchColumn();

        $stmt_select2 = $conn->prepare("SELECT nombre_entrada FROM entradas WHERE id_entrada = :id_entrada");
        $stmt_select2->bindParam(':id_entrada', $entrada, PDO::PARAM_INT);
        $stmt_select2->execute();
        $nombre_entrada = $stmt_select2->fetchColumn();

        $stmt_select3 = $conn->prepare("SELECT nombre_plato_fuerte FROM plato_fuerte WHERE id_plato_fuerte = :id_plato_fuerte");
        $stmt_select3->bindParam(':id_plato_fuerte', $plato, PDO::PARAM_INT);
        $stmt_select3->execute();
        $nombre_plato_fuerte = $stmt_select3->fetchColumn();

        $stmt_select4 = $conn->prepare("SELECT nombre_bebida FROM bebidas WHERE id_bebida = :id_bebida");
        $stmt_select4->bindParam(':id_bebida', $bebida, PDO::PARAM_INT);
        $stmt_select4->execute();
        $nombre_bebida = $stmt_select4->fetchColumn();

        $array_servicios = [];
        foreach ($servicios as $servicio) {
            $stmt_select5 = $conn->prepare("SELECT nombre_servicio FROM servicios WHERE id_servicio = :id_servicio");
            $stmt_select5->bindValue(':id_servicio', $servicio, PDO::PARAM_INT);
            $stmt_select5->execute();
            $array_servicios[] = $stmt_select5->fetchColumn();
        }
        $servicios_str = implode(", ", $array_servicios);

        $stmt_select6 = $conn->prepare("SELECT tipo_metodo_pago FROM metodo_pago WHERE id_metodo_pago = $metodo");
        $stmt_select6->execute();
        $nombre_metodo = $stmt_select6->fetchColumn();

            if ($ok1 && $ok2 && $ok3 && $ok4 && $ok5 && $ok6) {
                $conn->commit();
                echo "<h2>Paquete ingresado correctamente</h2>";
                echo $libreria->formato_cotizar($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $nombre_aperitivo, $nombre_entrada, $nombre_plato_fuerte, 
                            $nombre_bebida, $nombre_metodo, $servicios);
            } else {
                throw new Exception("Error en la ejecución de una o más operaciones.");
            }

    } catch (Exception $e) 
        {
            $conn->rollBack();
            echo "<h2>¡Ups!, ha ocurrido un error inesperado</h2>";
            echo "Detalles: " . $e->getMessage(); // Puedes quitar esto en producción
        }
}
else if (isset($_POST['cotizar-p2']))
{
    try {
        $conn->beginTransaction();
 
        //Variables recibidas del formulario
        $anfitrion = trim($_POST['anfitrion']); 
        $fecha     = trim($_POST['fecha']); 
        $lugar     = trim($_POST['lugar']); 
        $hora      = trim($_POST['hora']); 
        $duracion  = !empty($_POST['duracion']); 
        $invitados = !empty($_POST['invitados']); 
        $evento    = trim($_POST['tipo_evento']); 
        $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : []; 
        $aperitivo = !empty($_POST['aperitivo']);
        $entrada   = !empty($_POST['entrada']);
        $plato     = !empty($_POST['plato_fuerte']);
        $postre    = null;
        $bebida    = !empty($_POST['bebida']);
        $metodo    = !empty($_POST['metodo_pago']); 
        $paquete   = 'PAQUETE FIESTA';
        $invitados = 100;
        $costo_servicios = $libreria_aux->calc_costo_servicios($servicios);
        $costo_total     = $costo_servicios + ($invitados * 650);
        $referencia_pago = $libreria->referencia_pago($paquete, $evento, $fecha);

        $stmt = $conn->prepare("INSERT INTO evento(fecha_evento, lugar_evento, hora_evento, duracion_evento,
                                cantidad_invitados, tipo_evento) 
                                        VALUES (:fecha, :lugar, :hora, :duracion, :invitados, :tipo_evento)");
        $stmt->bindParam(':fecha'       , $fecha        , PDO::PARAM_STR);
        $stmt->bindParam(':lugar'       , $lugar        , PDO::PARAM_STR);
        $stmt->bindParam(':hora'        , $hora         , PDO::PARAM_STR);
        $stmt->bindParam(':duracion'    , $duracion     , PDO::PARAM_INT);
        $stmt->bindParam(':invitados'   , $invitados    , PDO::PARAM_INT);
        $stmt->bindParam(':tipo_evento' , $evento       , PDO::PARAM_STR);
        $ok1 = $stmt->execute();
        $id_evento = $conn->lastInsertId();

        $stmt2 = $conn->prepare("INSERT INTO paquete(nombre_paquete, anfitrion, fk_evento, fk_aperitivo, 
                                fk_entrada, fk_plato_fuerte, fk_postre, fk_bebida, fk_metodo_pago) 
                                VALUES (:paquete, :anfitrion, :evento, :aperitivo, :entrada, :plato_fuerte, 
                                :postre, :bebida, :metodo_pago)");

        $stmt2->bindParam(':paquete'     , $paquete      , PDO::PARAM_STR);
        $stmt2->bindParam(':anfitrion'   , $anfitrion    , PDO::PARAM_STR);
        $stmt2->bindParam(':evento'      , $id_evento    , PDO::PARAM_INT);
        $stmt2->bindParam(':aperitivo'   , $aperitivo    , PDO::PARAM_STR);
        $stmt2->bindParam(':entrada'     , $entrada      , PDO::PARAM_STR);
        $stmt2->bindParam(':plato_fuerte', $plato        , PDO::PARAM_STR);
        $stmt2->bindParam(':postre'      , $postre       , PDO::PARAM_STR);
        $stmt2->bindParam(':bebida'      , $bebida       , PDO::PARAM_STR);
        $stmt2->bindParam(':metodo_pago' , $metodo       , PDO::PARAM_STR);
        $ok2 = $stmt2->execute();
        $id_paquete = $conn->lastInsertId();

        $id_cliente = $_SESSION['id_usuario']; 
        $id_usuario = $id_cliente;

        if(!empty($_POST['servicios']))
        {
            $servicios = $_POST['servicios'];
            
            $ok3 = true;
            foreach($servicios as $servicio)
            {
                $stmt3 = $conn->prepare("INSERT INTO paquete_servicio(fk_paquete, fk_servicio, fk_cliente)
                                            VALUES (:id_paquete, :id_servicio, :id_cliente)");
                $stmt3->bindValue(':id_paquete' , $id_paquete , PDO::PARAM_INT);
                $stmt3->bindValue(':id_servicio' , $servicio  , PDO::PARAM_INT);
                $stmt3->bindValue(':id_cliente'  , $id_cliente , PDO::PARAM_INT);
                $ok3 = $ok3 && $stmt3->execute();
            }
        }
        
        $stmt4 = $conn->prepare("INSERT INTO cotizacion(fk_paquete, fk_cliente, fk_evento, total) 
                                            VALUES (:id_paquete, :id_cliente, :id_evento, :total_costo)");
        $stmt4->bindParam(':id_paquete' , $id_paquete , PDO::PARAM_INT);
        $stmt4->bindParam(':id_cliente' , $id_cliente , PDO::PARAM_INT);
        $stmt4->bindParam(':id_evento'  , $id_evento  , PDO::PARAM_INT);
        $stmt4->bindParam(':total_costo', $costo_total, PDO::PARAM_INT);
        $ok4 = $stmt4->execute();
        $id_cotizacion = $conn->lastInsertId();

        $fecha_pago  = $libreria->obtenerFecha()[5];
        $estado_pago = 'Pendiente'; 
        $stmt5       = $conn->prepare("INSERT INTO datos_pago(referencia_pago, fk_metodo_pago, estado_pago, 
                                        fecha_pago, fk_cliente, fk_usuario) 
                                        VALUES (:referencia_pago, :metodo_pago, :estado_pago, :fecha_pago, 
                                                :id_cliente, :id_usuario)");
        $stmt5->bindParam(':referencia_pago', $referencia_pago, PDO::PARAM_INT);
        $stmt5->bindParam(':metodo_pago'    , $metodo         , PDO::PARAM_STR);
        $stmt5->bindParam(':estado_pago'    , $estado_pago    , PDO::PARAM_STR);
        $stmt5->bindParam(':fecha_pago'     , $fecha_pago     , PDO::PARAM_STR);
        $stmt5->bindParam(':id_cliente'     , $id_cliente     , PDO::PARAM_INT);
        $stmt5->bindParam(':id_usuario'     , $id_usuario     , PDO::PARAM_INT);
        $ok5 = $stmt5->execute();
        $id_datos_pago = $conn->lastInsertId();

        $stmt6 = $conn->prepare("INSERT INTO pago(fk_paquete , fk_cotizacion, fk_cliente, fk_datos_pago) 
                                        VALUES (:id_paquete, :id_cotizacion, :id_cliente, :id_datos_pago)");
        $stmt6->bindParam(':id_paquete'   , $id_paquete    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cotizacion' , $id_cotizacion , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cliente'   , $id_cliente    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_datos_pago', $id_datos_pago , PDO::PARAM_INT);
        $ok6 = $stmt6->execute();

        //Obteniendo el nombre de las opciones seleccionadas
        $stmt_select1 = $conn->prepare("SELECT nombre_aperitivo FROM aperitivos WHERE id_aperitivo = :id_aperitivo");
        $stmt_select1->bindParam(':id_aperitivo', $aperitivo, PDO::PARAM_INT);
        $stmt_select1->execute();
        $nombre_aperitivo = $stmt_select1->fetchColumn();

        $stmt_select2 = $conn->prepare("SELECT nombre_entrada FROM entradas WHERE id_entrada = :id_entrada");
        $stmt_select2->bindParam(':id_entrada', $entrada, PDO::PARAM_INT);
        $stmt_select2->execute();
        $nombre_entrada = $stmt_select2->fetchColumn();

        $stmt_select3 = $conn->prepare("SELECT nombre_plato_fuerte FROM plato_fuerte WHERE id_plato_fuerte = :id_plato_fuerte");
        $stmt_select3->bindParam(':id_plato_fuerte', $plato, PDO::PARAM_INT);
        $stmt_select3->execute();
        $nombre_plato_fuerte = $stmt_select3->fetchColumn();

        $stmt_select4 = $conn->prepare("SELECT nombre_bebida FROM bebidas WHERE id_bebida = :id_bebida");
        $stmt_select4->bindParam(':id_bebida', $bebida, PDO::PARAM_INT);
        $stmt_select4->execute();
        $nombre_bebida = $stmt_select4->fetchColumn();

        $array_servicios = [];
        foreach ($servicios as $servicio) {
            $stmt_select5 = $conn->prepare("SELECT nombre_servicio FROM servicios WHERE id_servicio = :id_servicio");
            $stmt_select5->bindValue(':id_servicio', $servicio, PDO::PARAM_INT);
            $stmt_select5->execute();
            $array_servicios[] = $stmt_select5->fetchColumn();
        }
        $servicios_str = implode(", ", $array_servicios);

        $stmt_select6 = $conn->prepare("SELECT tipo_metodo_pago FROM metodo_pago WHERE id_metodo_pago = $metodo");
        $stmt_select6->execute();
        $nombre_metodo = $stmt_select6->fetchColumn();

            if ($ok1 && $ok2 && $ok3 && $ok4 && $ok5 && $ok6) {
                $conn->commit();
                echo "<h2>Paquete ingresado correctamente</h2>";
                echo $libreria->formato_cotizar($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $nombre_aperitivo, $nombre_entrada, $nombre_plato_fuerte, 
                            $nombre_bebida, $nombre_metodo, $servicios);
            } else {
                throw new Exception("Error en la ejecución de una o más operaciones.");
            }

    } 
    catch (Exception $e) 
    {
        $conn->rollBack();
        echo "<h2>¡Ups!, ha ocurrido un error inesperado</h2>";
        echo "Detalles: " . $e->getMessage(); // Puedes quitar esto en producción
    }       
}
else if (isset($_POST['cotizar-p3']))
{
    try {
        $conn->beginTransaction();
 
        //Variables recibidas del formulario
        $anfitrion = trim($_POST['anfitrion']); 
        $fecha     = trim($_POST['fecha']); 
        $lugar     = trim($_POST['lugar']); 
        $hora      = trim($_POST['hora']); 
        $duracion  = !empty($_POST['duracion']); 
        $invitados = !empty($_POST['invitados']); 
        $evento    = trim($_POST['tipo_evento']); 
        $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : []; 
        $aperitivo = !empty($_POST['aperitivo']);
        $entrada   = !empty($_POST['entrada']);
        $plato     = !empty($_POST['plato_fuerte']);
        $postre    = !empty($_POST['postre']);
        $bebida    = !empty($_POST['bebida']);
        $metodo    = !empty($_POST['metodo_pago']); 
        $paquete   = 'PAQUETE EVENTO';
        $invitados = 200;
        $costo_servicios = $libreria_aux->calc_costo_servicios($servicios);
        $costo_total     = $costo_servicios + ($invitados * 650);
        $referencia_pago = $libreria->referencia_pago($paquete, $evento, $fecha);

        $stmt = $conn->prepare("INSERT INTO evento(fecha_evento, lugar_evento, hora_evento, duracion_evento,
                                cantidad_invitados, tipo_evento) 
                                        VALUES (:fecha, :lugar, :hora, :duracion, :invitados, :tipo_evento)");
        $stmt->bindParam(':fecha'       , $fecha        , PDO::PARAM_STR);
        $stmt->bindParam(':lugar'       , $lugar        , PDO::PARAM_STR);
        $stmt->bindParam(':hora'        , $hora         , PDO::PARAM_STR);
        $stmt->bindParam(':duracion'    , $duracion     , PDO::PARAM_INT);
        $stmt->bindParam(':invitados'   , $invitados    , PDO::PARAM_INT);
        $stmt->bindParam(':tipo_evento' , $evento       , PDO::PARAM_STR);
        $ok1 = $stmt->execute();
        $id_evento = $conn->lastInsertId();

        $stmt2 = $conn->prepare("INSERT INTO paquete(nombre_paquete, anfitrion, fk_evento, fk_aperitivo, 
                                fk_entrada, fk_plato_fuerte, fk_postre, fk_bebida, fk_metodo_pago) 
                                VALUES (:paquete, :anfitrion, :evento, :aperitivo, :entrada, :plato_fuerte, 
                                :postre, :bebida, :metodo_pago)");

        $stmt2->bindParam(':paquete'     , $paquete      , PDO::PARAM_STR);
        $stmt2->bindParam(':anfitrion'   , $anfitrion    , PDO::PARAM_STR);
        $stmt2->bindParam(':evento'      , $id_evento    , PDO::PARAM_INT);
        $stmt2->bindParam(':aperitivo'   , $aperitivo    , PDO::PARAM_STR);
        $stmt2->bindParam(':entrada'     , $entrada      , PDO::PARAM_STR);
        $stmt2->bindParam(':plato_fuerte', $plato        , PDO::PARAM_STR);
        $stmt2->bindParam(':postre'      , $postre       , PDO::PARAM_STR);
        $stmt2->bindParam(':bebida'      , $bebida       , PDO::PARAM_STR);
        $stmt2->bindParam(':metodo_pago' , $metodo       , PDO::PARAM_STR);
        $ok2 = $stmt2->execute();
        $id_paquete = $conn->lastInsertId();

        $id_cliente = $_SESSION['id_usuario']; 
        $id_usuario = $id_cliente;

        if(!empty($_POST['servicios']))
        {
            $servicios = $_POST['servicios'];
            
            $ok3 = true;
            foreach($servicios as $servicio)
            {
                $stmt3 = $conn->prepare("INSERT INTO paquete_servicio(fk_paquete, fk_servicio, fk_cliente)
                                            VALUES (:id_paquete, :id_servicio, :id_cliente)");
                $stmt3->bindValue(':id_paquete' , $id_paquete , PDO::PARAM_INT);
                $stmt3->bindValue(':id_servicio' , $servicio  , PDO::PARAM_INT);
                $stmt3->bindValue(':id_cliente'  , $id_cliente, PDO::PARAM_INT);
                $ok3 = $ok3 && $stmt3->execute();
            }
        }
        
        $stmt4 = $conn->prepare("INSERT INTO cotizacion(fk_paquete, fk_cliente, fk_evento, total) 
                                            VALUES (:id_paquete, :id_cliente, :id_evento, :total_costo)");
        $stmt4->bindParam(':id_paquete' , $id_paquete , PDO::PARAM_INT);
        $stmt4->bindParam(':id_cliente' , $id_cliente , PDO::PARAM_INT);
        $stmt4->bindParam(':id_evento'  , $id_evento  , PDO::PARAM_INT);
        $stmt4->bindParam(':total_costo', $costo_total, PDO::PARAM_INT);
        $ok4 = $stmt4->execute();
        $id_cotizacion = $conn->lastInsertId();

        $fecha_pago  = $libreria->obtenerFecha()[5];
        $estado_pago = 'Pendiente'; 
        $stmt5       = $conn->prepare("INSERT INTO datos_pago(referencia_pago, fk_metodo_pago, estado_pago, 
                                        fecha_pago, fk_cliente, fk_usuario) 
                                        VALUES (:referencia_pago, :metodo_pago, :estado_pago, :fecha_pago, 
                                                :id_cliente, :id_usuario)");
        $stmt5->bindParam(':referencia_pago', $referencia_pago, PDO::PARAM_INT);
        $stmt5->bindParam(':metodo_pago'    , $metodo         , PDO::PARAM_STR);
        $stmt5->bindParam(':estado_pago'    , $estado_pago    , PDO::PARAM_STR);
        $stmt5->bindParam(':fecha_pago'     , $fecha_pago     , PDO::PARAM_STR);
        $stmt5->bindParam(':id_cliente'     , $id_cliente     , PDO::PARAM_INT);
        $stmt5->bindParam(':id_usuario'     , $id_usuario     , PDO::PARAM_INT);
        $ok5 = $stmt5->execute();
        $id_datos_pago = $conn->lastInsertId();

        $stmt6 = $conn->prepare("INSERT INTO pago(fk_paquete , fk_cotizacion, fk_cliente, fk_datos_pago) 
                                        VALUES (:id_paquete, :id_cotizacion, :id_cliente, :id_datos_pago)");
        $stmt6->bindParam(':id_paquete'   , $id_paquete    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cotizacion' , $id_cotizacion , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cliente'   , $id_cliente    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_datos_pago', $id_datos_pago , PDO::PARAM_INT);
        $ok6 = $stmt6->execute();

        //Obteniendo el nombre de las opciones seleccionadas
        $stmt_select1 = $conn->prepare("SELECT nombre_aperitivo FROM aperitivos WHERE id_aperitivo = :id_aperitivo");
        $stmt_select1->bindParam(':id_aperitivo', $aperitivo, PDO::PARAM_INT);
        $stmt_select1->execute();
        $nombre_aperitivo = $stmt_select1->fetchColumn();

        $stmt_select2 = $conn->prepare("SELECT nombre_entrada FROM entradas WHERE id_entrada = :id_entrada");
        $stmt_select2->bindParam(':id_entrada', $entrada, PDO::PARAM_INT);
        $stmt_select2->execute();
        $nombre_entrada = $stmt_select2->fetchColumn();

        $stmt_select3 = $conn->prepare("SELECT nombre_plato_fuerte FROM plato_fuerte WHERE id_plato_fuerte = :id_plato_fuerte");
        $stmt_select3->bindParam(':id_plato_fuerte', $plato, PDO::PARAM_INT);
        $stmt_select3->execute();
        $nombre_plato_fuerte = $stmt_select3->fetchColumn();

        $stmt_select4 = $conn->prepare("SELECT nombre_bebida FROM bebidas WHERE id_bebida = :id_bebida");
        $stmt_select4->bindParam(':id_bebida', $bebida, PDO::PARAM_INT);
        $stmt_select4->execute();
        $nombre_bebida = $stmt_select4->fetchColumn();

        $stmt_select6 = $conn->prepare("SELECT nombre_postre FROM postres WHERE id_postre = :id_postre");
        $stmt_select6->bindParam(':id_postre', $postre, PDO::PARAM_INT);
        $stmt_select6->execute();
        $nombre_postre = $stmt_select6->fetchColumn();

        $array_servicios = [];
        foreach ($servicios as $servicio) {
            $stmt_select5 = $conn->prepare("SELECT nombre_servicio FROM servicios WHERE id_servicio = :id_servicio");
            $stmt_select5->bindValue(':id_servicio', $servicio, PDO::PARAM_INT);
            $stmt_select5->execute();
            $array_servicios[] = $stmt_select5->fetchColumn();
        }
        $servicios_str = implode(", ", $array_servicios);

        $stmt_select6 = $conn->prepare("SELECT tipo_metodo_pago FROM metodo_pago WHERE id_metodo_pago = $metodo");
        $stmt_select6->execute();
        $nombre_metodo = $stmt_select6->fetchColumn();

            if ($ok1 && $ok2 && $ok3 && $ok4 && $ok5 && $ok6) {
                $conn->commit();
                echo "<h2>Paquete ingresado correctamente</h2>";
                echo $libreria->formato_cotizar2($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $nombre_aperitivo, $nombre_entrada, $nombre_plato_fuerte, 
                            $nombre_postre, $nombre_bebida, $nombre_metodo, $servicios);
            } else {
                throw new Exception("Error en la ejecución de una o más operaciones.");
            }

    } 
    catch (Exception $e) 
    {
        $conn->rollBack();
        echo "<h2>¡Ups!, ha ocurrido un error inesperado</h2>";
        echo "Detalles: " . $e->getMessage(); // Puedes quitar esto en producción
    }       

}
else if (isset($_POST['cotizar-p4']))
{
    try {
        $conn->beginTransaction();
 
        //Variables recibidas del formulario
        $anfitrion = trim($_POST['anfitrion']); 
        $fecha     = trim($_POST['fecha']); 
        $lugar     = trim($_POST['lugar']); 
        $hora      = trim($_POST['hora']); 
        $duracion  = !empty($_POST['duracion']); 
        $invitados = !empty($_POST['invitados']); 
        $evento    = trim($_POST['tipo_evento']); 
        $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : []; 
        $aperitivo = !empty($_POST['aperitivo']);
        $entrada   = !empty($_POST['entrada']);
        $plato     = !empty($_POST['plato_fuerte']);
        $postre    = !empty($_POST['postre']);
        $bebida    = !empty($_POST['bebida']);
        $metodo    = !empty($_POST['metodo_pago']); 
        $paquete   = 'PAQUETE EVENTO';
        $invitados = ($_POST['invitados']);
        $costo_servicios = $libreria_aux->calc_costo_servicios($servicios);
        $costo_total     = $costo_servicios + ($invitados * 650);
        $referencia_pago = $libreria->referencia_pago($paquete, $evento, $fecha);

        $stmt = $conn->prepare("INSERT INTO evento(fecha_evento, lugar_evento, hora_evento, duracion_evento,
                                cantidad_invitados, tipo_evento) 
                                        VALUES (:fecha, :lugar, :hora, :duracion, :invitados, :tipo_evento)");
        $stmt->bindParam(':fecha'       , $fecha        , PDO::PARAM_STR);
        $stmt->bindParam(':lugar'       , $lugar        , PDO::PARAM_STR);
        $stmt->bindParam(':hora'        , $hora         , PDO::PARAM_STR);
        $stmt->bindParam(':duracion'    , $duracion     , PDO::PARAM_INT);
        $stmt->bindParam(':invitados'   , $invitados    , PDO::PARAM_INT);
        $stmt->bindParam(':tipo_evento' , $evento       , PDO::PARAM_STR);
        $ok1 = $stmt->execute();
        $id_evento = $conn->lastInsertId();

        $stmt2 = $conn->prepare("INSERT INTO paquete(nombre_paquete, anfitrion, fk_evento, fk_aperitivo, 
                                fk_entrada, fk_plato_fuerte, fk_postre, fk_bebida, fk_metodo_pago) 
                                VALUES (:paquete, :anfitrion, :evento, :aperitivo, :entrada, :plato_fuerte, 
                                :postre, :bebida, :metodo_pago)");

        $stmt2->bindParam(':paquete'     , $paquete      , PDO::PARAM_STR);
        $stmt2->bindParam(':anfitrion'   , $anfitrion    , PDO::PARAM_STR);
        $stmt2->bindParam(':evento'      , $id_evento    , PDO::PARAM_INT);
        $stmt2->bindParam(':aperitivo'   , $aperitivo    , PDO::PARAM_STR);
        $stmt2->bindParam(':entrada'     , $entrada      , PDO::PARAM_STR);
        $stmt2->bindParam(':plato_fuerte', $plato        , PDO::PARAM_STR);
        $stmt2->bindParam(':postre'      , $postre       , PDO::PARAM_STR);
        $stmt2->bindParam(':bebida'      , $bebida       , PDO::PARAM_STR);
        $stmt2->bindParam(':metodo_pago' , $metodo       , PDO::PARAM_STR);
        $ok2 = $stmt2->execute();
        $id_paquete = $conn->lastInsertId();

        $id_cliente = $_SESSION['id_usuario']; 
        $id_usuario = $id_cliente;

        if(!empty($_POST['servicios']))
        {
            $servicios = $_POST['servicios'];
            
            $ok3 = true;
            foreach($servicios as $servicio)
            {
                $stmt3 = $conn->prepare("INSERT INTO paquete_servicio(fk_paquete, fk_servicio, fk_cliente)
                                            VALUES (:id_paquete, :id_servicio, :id_cliente)");
                $stmt3->bindValue(':id_paquete' , $id_paquete , PDO::PARAM_INT);
                $stmt3->bindValue(':id_servicio' , $servicio  , PDO::PARAM_INT);
                $stmt3->bindValue(':id_cliente'  , $id_cliente, PDO::PARAM_INT);
                $ok3 = $ok3 && $stmt3->execute();
            }
        }
        
        $stmt4 = $conn->prepare("INSERT INTO cotizacion(fk_paquete, fk_cliente, fk_evento, total) 
                                            VALUES (:id_paquete, :id_cliente, :id_evento, :total_costo)");
        $stmt4->bindParam(':id_paquete' , $id_paquete , PDO::PARAM_INT);
        $stmt4->bindParam(':id_cliente' , $id_cliente , PDO::PARAM_INT);
        $stmt4->bindParam(':id_evento'  , $id_evento  , PDO::PARAM_INT);
        $stmt4->bindParam(':total_costo', $costo_total, PDO::PARAM_INT);
        $ok4 = $stmt4->execute();
        $id_cotizacion = $conn->lastInsertId();

        $fecha_pago  = $libreria->obtenerFecha()[5];
        $estado_pago = 'Pendiente'; 
        $stmt5       = $conn->prepare("INSERT INTO datos_pago(referencia_pago, fk_metodo_pago, estado_pago, 
                                        fecha_pago, fk_cliente, fk_usuario) 
                                        VALUES (:referencia_pago, :metodo_pago, :estado_pago, :fecha_pago, 
                                                :id_cliente, :id_usuario)");
        $stmt5->bindParam(':referencia_pago', $referencia_pago, PDO::PARAM_INT);
        $stmt5->bindParam(':metodo_pago'    , $metodo         , PDO::PARAM_STR);
        $stmt5->bindParam(':estado_pago'    , $estado_pago    , PDO::PARAM_STR);
        $stmt5->bindParam(':fecha_pago'     , $fecha_pago     , PDO::PARAM_STR);
        $stmt5->bindParam(':id_cliente'     , $id_cliente     , PDO::PARAM_INT);
        $stmt5->bindParam(':id_usuario'     , $id_usuario     , PDO::PARAM_INT);
        $ok5 = $stmt5->execute();
        $id_datos_pago = $conn->lastInsertId();

        $stmt6 = $conn->prepare("INSERT INTO pago(fk_paquete , fk_cotizacion, fk_cliente, fk_datos_pago) 
                                        VALUES (:id_paquete, :id_cotizacion, :id_cliente, :id_datos_pago)");
        $stmt6->bindParam(':id_paquete'   , $id_paquete    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cotizacion' , $id_cotizacion , PDO::PARAM_INT);
        $stmt6->bindParam(':id_cliente'   , $id_cliente    , PDO::PARAM_INT);
        $stmt6->bindParam(':id_datos_pago', $id_datos_pago , PDO::PARAM_INT);
        $ok6 = $stmt6->execute();

        //Obteniendo el nombre de las opciones seleccionadas
        $stmt_select1 = $conn->prepare("SELECT nombre_aperitivo FROM aperitivos WHERE id_aperitivo = :id_aperitivo");
        $stmt_select1->bindParam(':id_aperitivo', $aperitivo, PDO::PARAM_INT);
        $stmt_select1->execute();
        $nombre_aperitivo = $stmt_select1->fetchColumn();

        $stmt_select2 = $conn->prepare("SELECT nombre_entrada FROM entradas WHERE id_entrada = :id_entrada");
        $stmt_select2->bindParam(':id_entrada', $entrada, PDO::PARAM_INT);
        $stmt_select2->execute();
        $nombre_entrada = $stmt_select2->fetchColumn();

        $stmt_select3 = $conn->prepare("SELECT nombre_plato_fuerte FROM plato_fuerte WHERE id_plato_fuerte = :id_plato_fuerte");
        $stmt_select3->bindParam(':id_plato_fuerte', $plato, PDO::PARAM_INT);
        $stmt_select3->execute();
        $nombre_plato_fuerte = $stmt_select3->fetchColumn();

        $stmt_select4 = $conn->prepare("SELECT nombre_bebida FROM bebidas WHERE id_bebida = :id_bebida");
        $stmt_select4->bindParam(':id_bebida', $bebida, PDO::PARAM_INT);
        $stmt_select4->execute();
        $nombre_bebida = $stmt_select4->fetchColumn();

        $stmt_select6 = $conn->prepare("SELECT nombre_postre FROM postres WHERE id_postre = :id_postre");
        $stmt_select6->bindParam(':id_postre', $postre, PDO::PARAM_INT);
        $stmt_select6->execute();
        $nombre_postre = $stmt_select6->fetchColumn();

        $array_servicios = [];
        foreach ($servicios as $servicio) {
            $stmt_select5 = $conn->prepare("SELECT nombre_servicio FROM servicios WHERE id_servicio = :id_servicio");
            $stmt_select5->bindValue(':id_servicio', $servicio, PDO::PARAM_INT);
            $stmt_select5->execute();
            $array_servicios[] = $stmt_select5->fetchColumn();
        }
        $servicios_str = implode(", ", $array_servicios);

        $stmt_select6 = $conn->prepare("SELECT tipo_metodo_pago FROM metodo_pago WHERE id_metodo_pago = $metodo");
        $stmt_select6->execute();
        $nombre_metodo = $stmt_select6->fetchColumn();

            if ($ok1 && $ok2 && $ok3 && $ok4 && $ok5 && $ok6) {
                $conn->commit();
                echo "<h2>Paquete ingresado correctamente</h2>";
                echo $libreria->formato_cotizar2($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $nombre_aperitivo, $nombre_entrada, $nombre_plato_fuerte, 
                            $nombre_postre, $nombre_bebida, $nombre_metodo, $servicios);
            } else {
                throw new Exception("Error en la ejecución de una o más operaciones.");
            }

    } 
    catch (Exception $e) 
    {
        $conn->rollBack();
        echo "<h2>¡Ups!, ha ocurrido un error inesperado</h2>";
        echo "Detalles: " . $e->getMessage(); // Puedes quitar esto en producción
    }   
}
else if(isset($_POST['cliente'])) 
{
    $id_usuario = $_SESSION['id_usuario']; // Obtenemos el id_usuario de la sesión

    if(!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) 
                                && !empty($_POST['estado']))
    {
        $nombre     = trim($_POST['nombre']);
        $apellido   = trim($_POST['apellido']);
        $telefono   = trim($_POST['telefono']);
        $estado     = trim($_POST['estado']);
        $fk_usuario = $id_usuario; 

        $stmt = $conn->prepare("INSERT INTO cliente(nombre, apellido, telefono, estado, fk_usuario) 
                                VALUES(:nombre, :apellido, :telefono, :estado, :fk_usuario)");

        $stmt->bindParam(':nombre'     , $nombre    , PDO::PARAM_STR);
        $stmt->bindParam(':apellido'   , $apellido  , PDO::PARAM_STR);
        $stmt->bindParam(':telefono'   , $telefono  , PDO::PARAM_STR);
        $stmt->bindParam(':estado'     , $estado    , PDO::PARAM_STR);
        $stmt->bindParam(':fk_usuario' , $fk_usuario, PDO::PARAM_INT);

        if($stmt->execute())
        {
            echo "<script>
            alert('Cliente ingresado correctamente');
            window.location.href = '../index.html'; // Redirige al usuario a la página principal
            </script>";
            exit(); 
        }
        else
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>¡Ups!, ha ocurrido un error inesperado</h2>";
        }
    }
}
else 
{
    echo "<h2 font-family='Times New Roman, Sain, Serif'>¡Ups!, ha ocurrido un error inesperado</h2>";
    echo "<script>
            alert('Redirigiendo a la página principal...');
            window.location.href = '../index.html'; // Redirige al usuario a la página principal
            </script>";
            exit(); 
}
?>