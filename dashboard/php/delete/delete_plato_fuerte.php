<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_plato_fuerte = $_GET['id_plato_fuerte'] ?? null;

if ($id_plato_fuerte) {
    $stmt = $conn->prepare("DELETE FROM plato_fuerte WHERE id_plato_fuerte = :id_plato_fuerte");
    $stmt->bindParam(':id_plato_fuerte', $id_plato_fuerte);
    
    if ($stmt->execute()) {
        header("Location: ../plato_fuerte.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el plato_fuerte.";
    }
} else {
    echo "Error: ID de plato_fuerte no proporcionado.";
}
?>