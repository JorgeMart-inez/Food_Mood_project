<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['agregar-aperitivo']))
{
    $id_aperitivo     = null;
    $nombre_aperitivo = $_POST['nombre_aperitivo'];

    $stmt = $conn->prepare("INSERT INTO aperitivos (nombre_aperitivo) 
                            VALUES (:nombre_aperitivo)");
    $stmt->bindParam(':nombre_aperitivo', $nombre_aperitivo);
    if($stmt->execute())
    {
        header("Location: aperitivo.php");
    }
}
else if(!empty($_POST['agregar-bebida']))
{
    $id_bebida     = null;
    $nombre_bebida = $_POST['nombre_bebida'];

    $stmt = $conn->prepare("INSERT INTO bebidas (nombre_bebida) 
                                    VALUES (:nombre_bebida)");
    $stmt->bindParam(':nombre_bebida', $nombre_bebida);
    if($stmt->execute())
    {
        header("Location: bebida.php");
    }
}
else if(!empty($_POST['agregar-plato-fuerte']))
{
    $id_plato_fuerte     = null;
    $nombre_plato_fuerte = $_POST['nombre_plato_fuerte'];

    $stmt = $conn->prepare("INSERT INTO plato_fuerte (nombre_plato_fuerte) 
                                    VALUES (:nombre_plato_fuerte)");
    $stmt->bindParam(':nombre_plato_fuerte', $nombre_plato_fuerte);
    if($stmt->execute())
    {
        header("Location: plato_fuerte.php");
    }
}
else if(!empty($_POST['agregar-entrada']))
{
    $id_entrada     = null;
    $nombre_entrada = $_POST['nombre_entrada'];

    $stmt = $conn->prepare("INSERT INTO entradas (nombre_entrada) 
                                    VALUES (:nombre_entrada)");
    $stmt->bindParam(':nombre_entrada', $nombre_entrada);
    if($stmt->execute())
    {
        header("Location: entrada.php");
    }
}
else if(!empty($_POST['agregar-postre']))
{
    $id_postre     = null;
    $nombre_postre = $_POST['nombre_postre'];

    $stmt = $conn->prepare("INSERT INTO postres (nombre_postre) 
                            VALUES (:nombre_postre)");
    $stmt->bindParam(':nombre_postre', $nombre_postre);
    if($stmt->execute())
    {
        header("Location: postre.php");
    }
}
else if(!empty($_POST['agregar-servicio']))
{
    $id_servicio     = null;
    $nombre_servicio = $_POST['nombre_servicio'];
    $precio_servicio = $_POST['precio_servicio'];

    $stmt = $conn->prepare("INSERT INTO servicios (nombre_servicio, precio_servicio) 
                            VALUES (:nombre_servicio, :precio_servicio)");
    $stmt->bindParam(':nombre_servicio', $nombre_servicio);
    $stmt->bindParam(':precio_servicio', $precio_servicio);
    if($stmt->execute())
    {
        header("Location: servicios.php");
    }
}
else if(!empty($_POST['agregar-metodo-pago']))
{
    $id_metodo_pago   = null;
    $tipo_metodo_pago = $_POST['tipo_metodo_pago'];

    $stmt = $conn->prepare("INSERT INTO metodo_pago (tipo_metodo_pago) 
                            VALUES (:tipo_metodo_pago)");
    $stmt->bindParam(':tipo_metodo_pago', $tipo_metodo_pago);
    if($stmt->execute())
    {
        header("Location: metodo_pago.php");
    }
}
else if(!empty($_POST['agregar-usuario']))
{
    $id_usuario      = null;
    $correo_usuario  = $_POST['correo'];
    $contrasenia1    = $_POST['contrasenia1'];
    $contrasenia2    = $_POST['contrasenia2'];
    $rol_usuario     = $_POST['rol'];

    if($contrasenia1 !== $contrasenia2)
    {
        echo "<script>alert('Las contraseñas no coinciden'); window.location.href='usuario.php';</script>";
        exit();
    }

    $sql = "SELECT * FROM usuario WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    if ($stmt->fetch()) 
    {
        echo "<script>alert('Ya existe una cuenta con este correo.'); window.location.href='usuario.php';</script>";
        exit();
    }


    $stmt = $conn->prepare("INSERT INTO usuario (correo, contrasenia, rol) 
                                    VALUES (:correo, :contrasenia1, :rol)");
    $stmt->bindParam(':correo'      , $correo_usuario);
    $stmt->bindParam(':contrasenia1', $contrasenia1);
    $stmt->bindParam(':rol'         , $rol_usuario);
    if($stmt->execute())
    {
        header("Location: usuario.php");
    }
}
else if(!empty($_POST['agregar-cliente']))
{
    $id_cliente       = null;
    $nombre_cliente   = $_POST['nombre_cliente'];
    $apellido_cliente = $_POST['apellido_cliente'];
    $telefono_cliente = $_POST['telefono_cliente'];
    $estado_cliente   = $_POST['estado_cliente'];
    $fk_usuario       = $_POST['fk_usuario'];


    $stmt = $conn->prepare("INSERT INTO cliente (nombre, apellido, telefono, estado, fk_usuario) 
                                    VALUES (:nombre_cliente, :apellido_cliente, :telefono_cliente, 
                                            :estado_cliente, :fk_usuario)");
    $stmt->bindParam(':nombre_cliente'  , $nombre_cliente);
    $stmt->bindParam(':apellido_cliente', $apellido_cliente);
    $stmt->bindParam(':telefono_cliente', $telefono_cliente);
    $stmt->bindParam(':estado_cliente'  , $estado_cliente);
    $stmt->bindParam(':fk_usuario'      , $fk_usuario);
    if($stmt->execute())
    {
        header("Location: cliente.php");
    }
}
else if(!empty($_POST['agregar-evento']))
{
    $id_evento          = null;
    $fecha_evento       = $_POST['fecha_evento'];
    $lugar_evento       = $_POST['lugar_evento'];
    $hora_evento        = $_POST['hora_evento'];
    $duracion_evento    = $_POST['duracion_evento'];
    $cantidad_invitados = $_POST['cantidad_invitados'];
    $tipo_evento        = $_POST['tipo_evento'];

    $stmt = $conn->prepare("INSERT INTO evento (fecha_evento, lugar_evento, hora_evento, duracion_evento, 
                                                        cantidad_invitados, tipo_evento)
                                    VALUES (:fecha_evento, :lugar_evento, :hora_evento, 
                                            :duracion_evento, :cantidad_invitados, :tipo_evento)");
    $stmt->bindParam(':fecha_evento'       , $fecha_evento);
    $stmt->bindParam(':lugar_evento'       , $lugar_evento);
    $stmt->bindParam(':hora_evento'        , $hora_evento);
    $stmt->bindParam(':duracion_evento'    , $duracion_evento);
    $stmt->bindParam(':cantidad_invitados' , $cantidad_invitados);
    $stmt->bindParam(':tipo_evento'        , $tipo_evento);
    if($stmt->execute())
    {
        header("Location: evento.php");
    }

}
else if(!empty($_POST['agregar-paquete']))
{
    $id_paquete         = null;
    $nombre_paquete     = $_POST['nombre_paquete'];
    $anfitrion          = $_POST['anfitrion'];
    $fk_evento          = $_POST['fk_evento'];
    $fk_aperitivo       = $_POST['fk_aperitivo'];
    $fk_entrada         = $_POST['fk_entrada'];
    $fk_plato_fuerte    = $_POST['fk_plato_fuerte'];
    $fk_postre          = $_POST['fk_postre'];
    $fk_bebida          = $_POST['fk_bebida'];
    $fk_metodo_pago     = $_POST['fk_metodo_pago'];

    $stmt = $conn->prepare("INSERT INTO paquete (nombre_paquete, anfitrion, fk_aperitivo, fk_aperitivo, 
                                    fk_entrada, fk_plato_fuerte, fk_postre, fk_bebida, fk_metodo_pago)
                                    VALUES (:nombre_paquete, :anfitrion, :fk_aperitivo, :fk_aperitivo, :fk_entrada,
                                            :fk_plato_fuerte, :fk_postre, :fk_bebida, :fk_metodo_pago)");
    $stmt->bindParam(':fecha_evento'     , $fecha_evento);
    $stmt->bindParam(':anfitrion'        , $anfitrion);
    $stmt->bindParam(':fk_aperitivo'     , $fk_aperitivo);
    $stmt->bindParam(':fk_aperitivo'     , $fk_aperitivo);
    $stmt->bindParam(':fk_entrada'       , $fk_entrada);
    $stmt->bindParam(':fk_plato_fuerte'  , $fk_plato_fuerte);
    $stmt->bindParam(':fk_postre'        , $fk_postre);
    $stmt->bindParam(':fk_bebida'        , $fk_bebida);
    $stmt->bindParam(':fk_metodo_pago'   , $fk_metodo_pago);
    if($stmt->execute())
    {
        header("Location: paquete.php");
    }
}
else if(!empty($_POST['agregar-paquete-servicio'])){
    $fk_paquete  = $_POST['id_paquete'];
    $fk_servicio = $_POST['id_servicio'];
    $fk_cliente  = $_POST['id_cliente'];

    $stmt = $conn->prepare("INSERT INTO paquete_servicio (fk_paquete, fk_servicio, fk_cliente)
                                    VALUES (:id_paquete, :id_servicio, :id_cliente)");
    $stmt->bindParam(':id_paquete' , $fk_paquete , PDO::PARAM_INT);
    $stmt->bindParam(':id_servicio', $fk_servicio, PDO::PARAM_INT);
    $stmt->bindParam(':id_cliente' , $fk_cliente , PDO::PARAM_INT);
    if($stmt->execute())
    {
        header("Location: paquete_servicio.php");
    }
}
else if(!empty($_POST['agregar-datos-pago'])){
    $referencia_pago = $_POST['referencia_pago'];
    $fk_metodo_pago  = $_POST['fk_metodo_pago'];
    $estado_pago     = $_POST['estado_pago'];
    $fecha_pago      = $_POST['fecha_pago'];
    $fk_cliente      = $_POST['fk_cliente'];
    $fk_usuario      = $_POST['fk_usuario'];

    $stmt = $conn->prepare("INSERT INTO datos_pago (referencia_pago, 
                                                            fk_metodo_pago, 
                                                            estado_pago, 
                                                            fecha_pago, 
                                                            fk_cliente, 
                                                            fk_usuario)
                                    VALUES (:referencia_pago, 
                                            :fk_metodo_pago, 
                                            :estado_pago, 
                                            :fecha_pago, 
                                            :fk_cliente, 
                                            :fk_usuario)");
    $stmt->bindParam(':referencia_pago', $referencia_pago, PDO::PARAM_STR);
    $stmt->bindParam(':fk_metodo_pago' , $fk_metodo_pago , PDO::PARAM_STR);
    $stmt->bindParam(':estado_pago'    , $estado_pago    , PDO::PARAM_STR);
    $stmt->bindParam(':fecha_pago'     , $fecha_pago     , PDO::PARAM_STR);
    $stmt->bindParam(':fk_cliente'     , $fk_cliente     , PDO::PARAM_INT);
    $stmt->bindParam(':fk_usuario'     , $fk_usuario     , PDO::PARAM_INT);
    if($stmt->execute())
    {
        header("Location: datos_pago.php");
    }
}
else if(!empty($_POST['agregar-pago'])){
    $fk_paquete    = $_POST['fk_paquete'];
    $fk_cotizacion = $_POST['fk_cotizacion'];
    $fk_cliente    = $_POST['fk_cliente'];
    $fk_datos_pago = $_POST['fk_datos_pago'];

    $stmt = $conn->prepare("INSERT INTO pago(fk_paquete, 
                                                    fk_cotizacion, 
                                                    fk_cliente, 
                                                    fk_datos_pago)
                                    VALUES (:fk_paquete, 
                                            :fk_cotizacion, 
                                            :fk_cliente,
                                            :fk_datos_pago)");
    $stmt->bindParam(':fk_paquete'   , $fk_paquete   , PDO::PARAM_INT);
    $stmt->bindParam(':fk_cotizacion', $fk_cotizacion, PDO::PARAM_INT);
    $stmt->bindParam(':fk_cliente'   , $fk_cliente   , PDO::PARAM_INT);
    $stmt->bindParam(':fk_datos_pago', $fk_datos_pago, PDO::PARAM_INT);
    if($stmt->execute()){
        header("Location: pago.php");
    }
}
else if(!empty($_POST['agregar-cotizacion'])){
    $fk_paquete = $_POST['fk_paquete'];
    $fk_cliente = $_POST['fk_cliente'];
    $fk_evento  = $_POST['fk_evento'];
    $total      = $_POST['total'];

    $stmt = $conn->prepare("INSERT INTO cotizacion (fk_paquete,
                                                            fk_cliente,
                                                            fk_evento,
                                                            total)
                                    VALUES (:fk_paquete,
                                            :fk_cliente,
                                            :fk_evento,
                                            :total)");
    $stmt->bindParam(':fk_paquete'   , $fk_paquete   , PDO::PARAM_INT);
    $stmt->bindParam(':fk_cliente'   , $fk_cliente   , PDO::PARAM_INT);
    $stmt->bindParam(':fk_evento'    , $fk_evento    , PDO::PARAM_INT);
    $stmt->bindParam(':total'        , $total        , PDO::PARAM_INT);
    if($stmt->execute()){
        header("Location: cotizacion.php");
    }
}
else
{
    echo "Error: No se pudo agregar el elemento.";
}
?>