<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-datos-pago']))
{
    $id_datos_pago   = $_POST['id_datos_pago'];
    $referencia_pago = $_POST['referencia_pago'];
    $fk_metodo_pago  = $_POST['fk_metodo_pago'];
    $estado_pago     = $_POST['estado_pago'];
    $fecha_pago      = $_POST['fecha_pago'];
    $fk_cliente      = $_POST['fk_cliente'];
    $fk_usuario      = $_POST['fk_usuario'];

    $stmt = $conn->prepare("UPDATE datos_pago 
                                    SET referencia_pago  = :referencia_pago,
                                        fk_metodo_pago   = :fk_metodo_pago, 
                                        estado_pago      = :estado_pago, 
                                        fecha_pago       = :fecha_pago, 
                                        fk_cliente       = :fk_cliente, 
                                        fk_usuario       = :fk_usuario
                                    WHERE id_datos_pago  = :id_datos_pago");
    $stmt->bindParam(':id_datos_pago'  , $id_datos_pago  , PDO::PARAM_INT);
    $stmt->bindParam(':referencia_pago', $referencia_pago, PDO::PARAM_STR);
    $stmt->bindParam(':fk_metodo_pago' , $fk_metodo_pago , PDO::PARAM_STR);
    $stmt->bindParam(':estado_pago'    , $estado_pago    , PDO::PARAM_STR);
    $stmt->bindParam(':fecha_pago'     , $fecha_pago     , PDO::PARAM_STR);
    $stmt->bindParam(':fk_cliente'     , $fk_cliente     , PDO::PARAM_INT);
    $stmt->bindParam(':fk_usuario'     , $fk_usuario     , PDO::PARAM_INT);
    
    if($stmt->execute())
    {
        header("Location: ../datos_pago.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../datos_pago.php");
}
else
{
    echo "Error: No se pudo modificar los datos de pago.";
}
?>