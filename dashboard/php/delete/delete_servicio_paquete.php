<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$fk_paquete = $_GET['fk_paquete'] ?? null;

if ($fk_paquete) {
    $stmt = $conn->prepare("DELETE FROM paquete_servicio WHERE fk_paquete = :fk_paquete");
    $stmt->bindParam(':fk_paquete', $fk_paquete);
    
    if ($stmt->execute()) {
        header("Location: ../paquete_servicio.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el paquete.";
    }
} else {
    echo "Error: ID de paquete no proporcionado.";
}
?>