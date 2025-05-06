<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_metodo_pago = $_GET['id_metodo_pago'] ?? null;

if ($id_metodo_pago) {
    $stmt = $conn->prepare("DELETE FROM metodo_pago WHERE id_metodo_pago = :id_metodo_pago");
    $stmt->bindParam(':id_metodo_pago', $id_metodo_pago);
    
    if ($stmt->execute()) {
        header("Location: metodo_pago.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el metodo de pago.";
    }
} else {
    echo "Error: ID de metodo de pago no proporcionado.";
}
?>