<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_aperitivo = $_GET['id_aperitivo'] ?? null;

if ($id_aperitivo) {
    $stmt = $conn->prepare("DELETE FROM aperitivos WHERE id_aperitivo = :id_aperitivo");
    $stmt->bindParam(':id_aperitivo', $id_aperitivo);
    
    if ($stmt->execute()) {
        header("Location: ../aperitivo.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el aperitivo.";
    }
} else {
    echo "Error: ID de aperitivo no proporcionado.";
}
?>