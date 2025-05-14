<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_datos_pago = $_GET['id_datos_pago'] ?? null;

if ($id_datos_pago) {
    $stmt = $conn->prepare("DELETE FROM datos_pago WHERE id_datos_pago = :id_datos_pago");
    $stmt->bindParam(':id_datos_pago', $id_datos_pago);
    
    if ($stmt->execute()) {
        header("Location: ../datos_pago.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar los datos del pago.";
    }
} else {
    echo "Error: ID de los datos de pago no proporcionado.";
}
?>