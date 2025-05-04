<?php
session_start();
include('conndb.php');
require_once __DIR__ . '/../libreria/includes/autoload.php';
use mi_libreria\util;   
use mi_libreria\mi_libreria;
$libreria = new mi_libreria();
$libreria_aux = new util();

//SON SEIS INSERTS EN TOTAL, LAS DEMAS TABLAS SON DE REFERENCIA
if (isset($_POST['cotizar-p1'])) {
    try {
        $conn->beginTransaction();
 
        //Variables recibidas del formulario
        $anfitrion = trim($_POST['anfitrion']); 
        $fecha     = trim($_POST['fecha']); 
        $lugar     = trim($_POST['lugar']); 
        $hora      = trim($_POST['hora']); 
        $duracion  = ($_POST['duracion']); 
        $invitados = ($_POST['invitados']); 
        $evento    = trim($_POST['tipo_evento']); 
        $servicios = isset($_POST['servicios']) ? $_POST['servicios'] : []; 
        $aperitivo = ($_POST['aperitivo']);
        $entrada   = ($_POST['entrada']);
        $plato     = ($_POST['plato_fuerte']);
        $postre    = null;
        $bebida    = ($_POST['bebida']);
        $metodo    = ($_POST['metodo_pago']);
        $servicios_str = implode(", ", $servicios); 
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

            if ($ok1 && $ok2 && $ok3 && $ok4 && $ok5 && $ok6) {
                $conn->commit();
                echo "<h2>Paquete ingresado correctamente</h2>";
                echo $libreria->formato_cotizar($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $aperitivo, $entrada, $plato, $bebida, $metodo, $servicios);
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
        $paquete   = 'PAQUETE FIESTA';
        $invitados = 100;

        $stmt = $conn->prepare("INSERT INTO paquete(nombre_paquete, anfitrion, fecha_evento, lugar_evento, hora_evento, duracion_evento,cantidad_invitados,
                                                    tipo_evento, servicios, aperitivo, entrada, plato_fuerte, postre, bebida, metodo_pago) 
                                        VALUES (:paquete, :anfitrion, :fecha, :lugar, :hora, :duracion, :invitados, :tipo_evento, :servicios,
                                                :aperitivo, :entrada, :plato_fuerte, :postre, :bebida, :metodo_pago)");
                            
        $stmt->bindParam(':paquete'     , $paquete      , PDO::PARAM_STR);
        $stmt->bindParam(':anfitrion'   , $anfitrion    , PDO::PARAM_STR);
        $stmt->bindParam(':fecha'       , $fecha        , PDO::PARAM_STR);
        $stmt->bindParam(':lugar'       , $lugar        , PDO::PARAM_STR);
        $stmt->bindParam(':hora'        , $hora         , PDO::PARAM_STR);
        $stmt->bindParam(':duracion'    , $duracion     , PDO::PARAM_INT);
        $stmt->bindParam(':invitados'   , $invitados    , PDO::PARAM_INT);
        $stmt->bindParam(':tipo_evento' , $evento       , PDO::PARAM_STR);
        $stmt->bindParam(':servicios'   , $servicios_str, PDO::PARAM_STR);
        $stmt->bindParam(':aperitivo'   , $aperitivo    , PDO::PARAM_STR);
        $stmt->bindParam(':entrada'     , $entrada      , PDO::PARAM_STR);
        $stmt->bindParam(':plato_fuerte', $plato        , PDO::PARAM_STR);
        $stmt->bindParam(':postre'      , $postre       , PDO::PARAM_STR);
        $stmt->bindParam(':bebida'      , $bebida       , PDO::PARAM_STR);
        $stmt->bindParam(':metodo_pago' , $metodo       , PDO::PARAM_STR);

        if($stmt->execute())
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>Paquete ingresado correctamente</h2>";
            //echo $libreria->formato_pdf1($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
            //                $invitados, $servicios_str, $aperitivo, $entrada, $plato, $bebida, $metodo, $servicios);
            echo $libreria->formato_cotizar($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $aperitivo, $entrada, $plato, $bebida, $metodo, $servicios);
        }
        else
            {
                echo "<h2 font-family='Times New Roman, Sain, Serif'>¡Ups!, ha ocurrido un error inesperado</h2>";
            }
        

        exit();
}
else if (isset($_POST['cotizar-p3']))
{
        
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
        $postre    = trim($_POST['postre']);
        $bebida    = trim($_POST['bebida']);
        $metodo    = trim($_POST['metodo_pago']);
        $servicios_str = implode(", ", $servicios); 

        //Constantes declaradas segun el paquete
        $paquete   = "PAQUETE EVENTO";
        $invitados = 200;

        $stmt = $conn->prepare("INSERT INTO paquete(nombre_paquete, anfitrion, fecha_evento, lugar_evento, hora_evento, duracion_evento,cantidad_invitados,
                                                            tipo_evento, servicios, aperitivo, entrada, plato_fuerte, postre, bebida, metodo_pago) 
                                            VALUES (:paquete, :anfitrion, :fecha, :lugar, :hora, :duracion, :invitados, :tipo_evento, :servicios,
                                                    :aperitivo, :entrada, :plato_fuerte, :postre, :bebida, :metodo_pago)");

        $stmt->bindParam(':paquete'     , $paquete      , PDO::PARAM_STR);
        $stmt->bindParam(':anfitrion'   , $anfitrion    , PDO::PARAM_STR);
        $stmt->bindParam(':fecha'       , $fecha        , PDO::PARAM_STR);
        $stmt->bindParam(':lugar'       , $lugar        , PDO::PARAM_STR);
        $stmt->bindParam(':hora'        , $hora         , PDO::PARAM_STR);
        $stmt->bindParam(':duracion'    , $duracion     , PDO::PARAM_INT);
        $stmt->bindParam(':invitados'   , $invitados    , PDO::PARAM_INT);
        $stmt->bindParam(':tipo_evento' , $evento       , PDO::PARAM_STR);
        $stmt->bindParam(':servicios'   , $servicios_str, PDO::PARAM_STR);
        $stmt->bindParam(':aperitivo'   , $aperitivo    , PDO::PARAM_STR);
        $stmt->bindParam(':entrada'     , $entrada      , PDO::PARAM_STR);
        $stmt->bindParam(':plato_fuerte', $plato        , PDO::PARAM_STR);
        $stmt->bindParam(':postre'      , $postre       , PDO::PARAM_STR);
        $stmt->bindParam(':bebida'      , $bebida       , PDO::PARAM_STR);
        $stmt->bindParam(':metodo_pago' , $metodo       , PDO::PARAM_STR);

        if($stmt->execute())
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>Paquete ingresado correctamente</h2>";
            //echo $libreria->formato_pdf2($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
            //                $invitados, $servicios_str, $aperitivo, $entrada, $plato, $postre, $bebida, $metodo, $servicios);
            echo $libreria->formato_cotizar2($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $aperitivo, $entrada, $plato, $postre, $bebida, $metodo, $servicios);
        }
        else
            {
                echo "<h2 font-family='Times New Roman, Sain, Serif'>¡Ups!, ha ocurrido un error inesperado</h2>";
            }

        exit();

}
else if (isset($_POST['cotizar-p4']))
{
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
        $postre    = trim($_POST['postre']);
        $bebida    = trim($_POST['bebida']);
        $metodo    = trim($_POST['metodo_pago']);
        $servicios_str = implode(", ", $servicios); 

        //Constantes declaradas segun el paquete
        $paquete   = "PAQUETE PERSONALIZADO";

        $stmt = $conn->prepare("INSERT INTO paquete(nombre_paquete, anfitrion, fecha_evento, lugar_evento, hora_evento, duracion_evento,cantidad_invitados,
                                                            tipo_evento, servicios, aperitivo, entrada, plato_fuerte, postre, bebida, metodo_pago) 
                                    VALUES (:paquete, :anfitrion, :fecha, :lugar, :hora, :duracion, :invitados, :tipo_evento, :servicios,
                                            :aperitivo, :entrada, :plato_fuerte, :postre, :bebida, :metodo_pago)");
           
        $stmt->bindParam(':paquete'     , $paquete      , PDO::PARAM_STR);
        $stmt->bindParam(':anfitrion'   , $anfitrion    , PDO::PARAM_STR);
        $stmt->bindParam(':fecha'       , $fecha        , PDO::PARAM_STR);
        $stmt->bindParam(':lugar'       , $lugar        , PDO::PARAM_STR);
        $stmt->bindParam(':hora'        , $hora         , PDO::PARAM_STR);
        $stmt->bindParam(':duracion'    , $duracion     , PDO::PARAM_INT);
        $stmt->bindParam(':invitados'   , $invitados    , PDO::PARAM_INT);
        $stmt->bindParam(':tipo_evento' , $evento       , PDO::PARAM_STR);
        $stmt->bindParam(':servicios'   , $servicios_str, PDO::PARAM_STR);
        $stmt->bindParam(':aperitivo'   , $aperitivo    , PDO::PARAM_STR);
        $stmt->bindParam(':entrada'     , $entrada      , PDO::PARAM_STR);
        $stmt->bindParam(':plato_fuerte', $plato        , PDO::PARAM_STR);
        $stmt->bindParam(':postre'      , $postre       , PDO::PARAM_STR);
        $stmt->bindParam(':bebida'      , $bebida       , PDO::PARAM_STR);
        $stmt->bindParam(':metodo_pago' , $metodo       , PDO::PARAM_STR);

        if($stmt->execute())
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>Paquete ingresado correctamente</h2>";
            echo "<h2 font-family='Times New Roman, Sain, Serif'>Paquete ingresado correctamente</h2>";
            //echo $libreria->formato_pdf2($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
            //                $invitados, $servicios_str, $aperitivo, $entrada, $plato, $postre, $bebida, $metodo, $servicios);
            echo $libreria->formato_cotizar2($paquete, $anfitrion, $evento, $lugar, $fecha, $hora, $duracion,
                            $invitados, $servicios_str, $aperitivo, $entrada, $plato, $postre, $bebida, $metodo, $servicios);
        }
        else
            {
                echo "<h2 font-family='Times New Roman, Sain, Serif'>¡Ups!, ha ocurrido un error inesperado</h2>";
            }

        exit();
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
else if(isset($_POST['cotizacion']))
{
    if(!empty($_POST['id_paquete']))
    {
        $id_paquete = ($_POST['id_paquete']);

        $stmt = $conn->prepare("SELECT total_costo FROM paquete WHERE id_paquete = :id_paquete");
        $stmt->bindParam(':id_paquete', $id_paquete, PDO::PARAM_INT);
        $stmt->execute();
        $total_costo = $stmt->fetchColumn();

        if($total_costo != false)
        {
            $stmt_insert = $conn->prepare("INSERT INTO cotizacion(id_paquete, total) VALUES(:id_paquete, :total)");
            $stmt_insert->bindParam(':id_paquete' , $id_paquete , PDO::PARAM_INT);
            $stmt_insert->bindParam(':total', $total_costo, PDO::PARAM_STR);
            $stmt_insert->execute();

            echo "<h2 font-family='Times New Roman, Sain, Serif'>Cotización registrada con éxito!!</h2>";
        }
        else
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>¡Ups!, no se ha encontrado el paquete :c</h2>";
        }
        
    }
}
else if(isset($_POST['pago']))
{
    if(!empty($_POST['id_paquete']) && !empty($_POST['id_cotizacion']) && !empty($_POST['id_usuario'])
                                    && !empty($_POST['fecha_pago'])    && !empty($_POST['estado_pago']))
    {
        $id_paquete    = ($_POST['id_paquete']);
        $id_cotizacion = ($_POST['id_cotizacion']);
        $id_usuario    = ($_POST['id_usuario']);
        $fecha_pago    = ($_POST['fecha_pago']);
        $estado_pago   = ($_POST['estado_pago']);

        //referencia de pago, total_pago, metodo_pago, usuario (correo)
        $stmt = $conn->prepare("SELECT anfitrion FROM paquete WHERE id_paquete = :id_paquete");
        $stmt->bindParam(':id_paquete', $id_paquete, PDO::PARAM_INT);
        $stmt->execute();
        $anfitrion = $stmt->fetchColumn(); //necesario para referencia_pago

        $stmt = $conn->prepare("SELECT tipo_evento FROM paquete WHERE id_paquete = :id_paquete");
        $stmt->bindParam(':id_paquete', $id_paquete, PDO::PARAM_INT);
        $stmt->execute();
        $tipo_evento = $stmt->fetchColumn(); //necesario para referencia_pago

        $stmt = $conn->prepare("SELECT fecha_evento FROM paquete WHERE id_paquete = :id_paquete");
        $stmt->bindParam(':id_paquete', $id_paquete, PDO::PARAM_INT);
        $stmt->execute();
        $fecha_evento = $stmt->fetchColumn(); //necesario para referencia_pago

        $stmt = $conn->prepare("SELECT metodo_pago FROM paquete WHERE id_paquete = :id_paquete");
        $stmt->bindParam(':id_paquete', $id_paquete, PDO::PARAM_INT);
        $stmt->execute();
        $metodo_pago = $stmt->fetchColumn();

        $referencia_pago = strtoupper(substr(md5($anfitrion . $tipo_evento . $fecha_evento), 0, 10)); //anfitrion, tipo_evento, fecha_evento
        
        //total pago
        $stmt = $conn->prepare("SELECT total FROM cotizacion WHERE id_cotizacion = :id_cotizacion");
        $stmt->bindParam(':id_cotizacion', $id_cotizacion, PDO::PARAM_INT);
        $stmt->execute();
        $total_pago = $stmt->fetchColumn();

        //Usuario (correo)
        $stmt = $conn->prepare("SELECT correo FROM usuario WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetchColumn();
        
        if($anfitrion && $tipo_evento && $fecha_evento && $metodo_pago && $total_pago && $usuario !== false)
        {
            $stmt_insert = $conn->prepare("INSERT INTO pago(id_paquete, id_cotizacion, id_usuario, referencia_pago, total_pago,
                                                                    metodo_pago, estado_pago, fecha_pago, usuario)
                                                    VALUES(:id_paquete , :id_cotizacion, :id_usuario, :referencia_pago, :total_pago,
                                                            :metodo_pago, :estado_pago  , :fecha_pago, :usuario)");
            $stmt_insert->bindParam(':id_paquete'     , $id_paquete     , PDO::PARAM_INT);
            $stmt_insert->bindParam(':id_cotizacion'  , $id_cotizacion  , PDO::PARAM_INT);
            $stmt_insert->bindParam(':id_usuario'     , $id_usuario     , PDO::PARAM_INT);
            $stmt_insert->bindParam(':referencia_pago', $referencia_pago, PDO::PARAM_STR);
            $stmt_insert->bindParam(':total_pago'     , $total_pago     , PDO::PARAM_STR);
            $stmt_insert->bindParam(':metodo_pago'    , $metodo_pago    , PDO::PARAM_STR);
            $stmt_insert->bindParam(':estado_pago'    , $estado_pago    , PDO::PARAM_STR);
            $stmt_insert->bindParam(':fecha_pago'     , $fecha_pago     , PDO::PARAM_STR);
            $stmt_insert->bindParam(':usuario'        , $usuario        , PDO::PARAM_STR);
            $stmt_insert->execute();

            echo "<h2 font-family='Times New Roman, Sain, Serif'>Pago registrado con éxito!!</h2>";
        }
        else
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>¡Ups!, no se ha encontrado el paquete :c</h2>";
        }
    }
}
?>