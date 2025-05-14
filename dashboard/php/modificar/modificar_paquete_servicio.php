<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-paquete-servicio']))
{
    $fk_paquete  = $_POST['fk_paquete'];
    $fk_servicio = $_POST['fk_servicio'];   
    $fk_cliente  = $_POST['fk_cliente'];

    $stmt = $conn->prepare("UPDATE paquete_servicio 
                                    SET fk_servicio = :fk_servicio,
                                        fk_cliente  = :fk_cliente
                                    WHERE fk_paquete = :fk_paquete");
    $stmt->bindParam(':fk_paquete', $fk_paquete);
    $stmt->bindParam(':fk_servicio', $fk_servicio);
    $stmt->bindParam(':fk_cliente', $fk_cliente);
    if($stmt->execute())
    {
        header("Location: ../paquete_servicio.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../paquete_servicio.php");
}
else
{
    echo "Error: No se pudo modificar el paquete servicio.";
}
?>