<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_servicio = $_GET['id_servicio'] ?? null;

if ($id_servicio) {
    $stmt = $conn->prepare("DELETE FROM servicios WHERE id_servicio = :id_servicio");
    $stmt->bindParam(':id_servicio', $id_servicio);
    
    if ($stmt->execute()) {
        header("Location: ../servicios.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el servicio.";
    }
} else {
    echo "Error: ID de servicio no proporcionado.";
}
?>