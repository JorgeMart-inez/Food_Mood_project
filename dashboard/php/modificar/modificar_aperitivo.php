<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-aperitivo']))
{
    $id_aperitivo     = $_POST['id_aperitivo'];
    $nombre_aperitivo = $_POST['nombre_aperitivo'];

    $stmt = $conn->prepare("UPDATE aperitivos SET nombre_aperitivo = :nombre_aperitivo WHERE id_aperitivo = :id_aperitivo");
    $stmt->bindParam(':id_aperitivo', $id_aperitivo);
    $stmt->bindParam(':nombre_aperitivo', $nombre_aperitivo);
    if($stmt->execute())
    {
        header("Location: ../aperitivo.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../aperitivo.php");
}
else
{
    echo "Error: No se pudo modificar el aperitivo.";
}
?>