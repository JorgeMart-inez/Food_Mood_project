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
    $id_metodo_pago     = null;
    $tipo_metodo_pago = $_POST['tipo_metodo_pago'];

    $stmt = $conn->prepare("INSERT INTO metodo_pago (tipo_metodo_pago) 
                            VALUES (:tipo_metodo_pago)");
    $stmt->bindParam(':tipo_metodo_pago', $tipo_metodo_pago);
    if($stmt->execute())
    {
        header("Location: metodo_pago.php");
    }
}
else
{
    echo "Error: No se pudo agregar el elemento.";
}
?>