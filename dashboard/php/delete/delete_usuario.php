<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_usuario = $_GET['id_usuario'] ?? null;

if ($id_usuario) {
    $stmt = $conn->prepare("DELETE FROM usuario WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':id_usuario', $id_usuario);
    
    if ($stmt->execute()) {
        header("Location: ../usuario.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el usuario.";
    }
} else {
    echo "Error: ID de usuario no proporcionado.";
}
?>