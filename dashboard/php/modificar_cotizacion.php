<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-cotizacion']))
{
    $id_cotizacion = $_POST['id_cotizacion'];
    $fk_paquete    = $_POST['fk_paquete'];
    $fk_cliente    = $_POST['fk_cliente'];
    $fk_evento     = $_POST['fk_evento'];
    $total         = $_POST['total'];

    $stmt = $conn->prepare("UPDATE cotizacion
                                    SET fk_paquete    = :fk_paquete,
                                        fk_cliente    = :fk_cliente,
                                        fk_evento     = :fk_evento,
                                        total         = :total
                                    WHERE id_cotizacion = :id_cotizacion");
    $stmt->bindParam(':id_cotizacion', $id_cotizacion);
    $stmt->bindParam(':fk_paquete'   , $fk_paquete);
    $stmt->bindParam(':fk_cliente'   , $fk_cliente);
    $stmt->bindParam(':fk_evento'    , $fk_evento);
    $stmt->bindParam(':total'        , $total);

    if($stmt->execute())
    {
        header("Location: cotizacion.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: cotizacion.php");
}
else
{
    echo "Error: No se pudo modificar la cotizacion.";
}
?>