<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_cotizacion = $_GET['id_cotizacion'] ?? null;

if ($id_cotizacion) {
    $stmt = $conn->prepare("DELETE FROM cotizacion WHERE id_cotizacion = :id_cotizacion");
    $stmt->bindParam(':id_cotizacion', $id_cotizacion);
    
    if ($stmt->execute()) {
        header("Location: cotizacion.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar la cotizacion.";
    }
} else {
    echo "Error: ID de cotizacion no proporcionado.";
}
?>