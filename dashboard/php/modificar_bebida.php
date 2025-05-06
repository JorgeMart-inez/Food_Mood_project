<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-bebida']))
{
    $id_bebida     = $_POST['id_bebida'];
    $nombre_bebida = $_POST['nombre_bebida'];

    $stmt = $conn->prepare("UPDATE bebidas SET nombre_bebida = :nombre_bebida WHERE id_bebida = :id_bebida");
    $stmt->bindParam(':id_bebida', $id_bebida);
    $stmt->bindParam(':nombre_bebida', $nombre_bebida);
    if($stmt->execute())
    {
        header("Location: bebida.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: bebida.php");
}
else
{
    echo "Error: No se pudo modificar el bebida.";
}
?>