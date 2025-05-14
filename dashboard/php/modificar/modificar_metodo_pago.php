<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-metodo-pago']))
{
    $id_metodo_pago   = $_POST['id_metodo_pago'];
    $tipo_metodo_pago = $_POST['tipo_metodo_pago'];

    $stmt = $conn->prepare("UPDATE metodo_pago SET tipo_metodo_pago = :tipo_metodo_pago WHERE id_metodo_pago = :id_metodo_pago");
    $stmt->bindParam(':id_metodo_pago', $id_metodo_pago);
    $stmt->bindParam(':tipo_metodo_pago', $tipo_metodo_pago);
    if($stmt->execute())
    {
        header("Location: ../metodo_pago.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../metodo_pago.php");
}
else
{
    echo "Error: No se pudo modificar el metodo de pago.";
}
?>