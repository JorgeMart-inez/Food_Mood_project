<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_entrada = $_GET['id_entrada'] ?? null;

if ($id_entrada) {
    $stmt = $conn->prepare("DELETE FROM entradas WHERE id_entrada = :id_entrada");
    $stmt->bindParam(':id_entrada', $id_entrada);
    
    if ($stmt->execute()) {
        header("Location: ../entrada.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el entrada.";
    }
} else {
    echo "Error: ID de entrada no proporcionado.";
}
?>