<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_paquete = $_GET['id_paquete'] ?? null;

if ($id_paquete) {
    $stmt = $conn->prepare("DELETE FROM paquete WHERE id_paquete = :id_paquete");
    $stmt->bindParam(':id_paquete', $id_paquete);
    
    if ($stmt->execute()) {
        header("Location: ../paquete.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el paquete.";
    }
} else {
    echo "Error: ID de paquete no proporcionado.";
}
?>