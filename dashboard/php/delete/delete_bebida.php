<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_bebida = $_GET['id_bebida'] ?? null;

if ($id_bebida) {
    $stmt = $conn->prepare("DELETE FROM bebidas WHERE id_bebida = :id_bebida");
    $stmt->bindParam(':id_bebida', $id_bebida);
    
    if ($stmt->execute()) {
        header("Location: ../bebida.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el bebida.";
    }
} else {
    echo "Error: ID de bebida no proporcionado.";
}
?>