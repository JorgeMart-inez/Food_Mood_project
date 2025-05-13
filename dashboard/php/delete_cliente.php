<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

$id_cliente = $_GET['id_cliente'] ?? null;

if ($id_cliente) {
    $stmt = $conn->prepare("DELETE FROM cliente WHERE id_cliente = :id_cliente");
    $stmt->bindParam(':id_cliente', $id_cliente);
    
    if ($stmt->execute()) {
        header("Location: cliente.php");
        exit;
    } else {
        echo "Error: No se pudo eliminar el cliente.";
    }
} else {
    echo "Error: ID de cliente no proporcionado.";
}
?>