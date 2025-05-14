<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-pago']))
{
    $id_pago       = $_POST['id_pago'];
    $fk_paquete    = $_POST['fk_paquete'];
    $fk_cotizacion = $_POST['fk_cotizacion'];
    $fk_cliente    = $_POST['fk_cliente'];
    $fk_datos_pago = $_POST['fk_datos_pago'];

    $stmt = $conn->prepare("UPDATE pago
                                    SET fk_paquete    = :fk_paquete,
                                        fk_cotizacion = :fk_cotizacion,
                                        fk_cliente    = :fk_cliente,
                                        fk_datos_pago = :fk_datos_pago
                                    WHERE   id_pago   = :id_pago");
    $stmt->bindParam(':id_pago'      , $id_pago);
    $stmt->bindParam(':fk_paquete'   , $fk_paquete);
    $stmt->bindParam(':fk_cotizacion', $fk_cotizacion);
    $stmt->bindParam(':fk_cliente'   , $fk_cliente);
    $stmt->bindParam(':fk_datos_pago', $fk_datos_pago);

    if($stmt->execute())
    {
        header("Location: ../pago.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../pago.php");
}
else
{
    echo "Error: No se pudo modificar el pago.";
}
?>