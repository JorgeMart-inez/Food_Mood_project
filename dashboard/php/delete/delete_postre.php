<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_postre = $_GET['id_postre'] ?? null;

if ($id_postre) {
    $stmt = $conn->prepare("DELETE FROM postres WHERE id_postre = :id_postre");
    $stmt->bindParam(':id_postre', $id_postre);
    
    if ($stmt->execute()) {
        header("Location: ../postre.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el postre.";
    }
} else {
    echo "Error: ID de postre no proporcionado.";
}
?>