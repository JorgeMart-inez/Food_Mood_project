<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_evento = $_GET['id_evento'] ?? null;

if ($id_evento) {
    $stmt = $conn->prepare("DELETE FROM evento WHERE id_evento = :id_evento");
    $stmt->bindParam(':id_evento', $id_evento);
    
    if ($stmt->execute()) {
        header("Location: evento.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el evento.";
    }
} else {
    echo "Error: ID de evento no proporcionado.";
}
?>