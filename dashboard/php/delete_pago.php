<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_pago = $_GET['id_pago'] ?? null;

if ($id_pago) {
    $stmt = $conn->prepare("DELETE FROM pago WHERE id_pago = :id_pago");
    $stmt->bindParam(':id_pago', $id_pago);
    
    if ($stmt->execute()) {
        header("Location: pago.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el pago.";
    }
} else {
    echo "Error: ID del pago no proporcionado.";
}
?>