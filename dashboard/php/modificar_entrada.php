<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-entrada']))
{
    $id_entrada     = $_POST['id_entrada'];
    $nombre_entrada = $_POST['nombre_entrada'];

    $stmt = $conn->prepare("UPDATE entradas SET nombre_entrada = :nombre_entrada WHERE id_entrada = :id_entrada");
    $stmt->bindParam(':id_entrada', $id_entrada);
    $stmt->bindParam(':nombre_entrada', $nombre_entrada);
    if($stmt->execute())
    {
        header("Location: entrada.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: entrada.php");
}
else
{
    echo "Error: No se pudo modificar el entrada.";
}
?>