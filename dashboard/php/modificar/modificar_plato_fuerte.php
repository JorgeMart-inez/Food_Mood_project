<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-plato-fuerte']))
{
    $id_plato_fuerte     = $_POST['id_plato_fuerte'];
    $nombre_plato_fuerte = $_POST['nombre_plato_fuerte'];

    $stmt = $conn->prepare("UPDATE plato_fuerte SET nombre_plato_fuerte = :nombre_plato_fuerte WHERE id_plato_fuerte = :id_plato_fuerte");
    $stmt->bindParam(':id_plato_fuerte', $id_plato_fuerte);
    $stmt->bindParam(':nombre_plato_fuerte', $nombre_plato_fuerte);
    if($stmt->execute())
    {
        header("Location: ../plato_fuerte.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../plato_fuerte.php");
}
else
{
    echo "Error: No se pudo modificar el plato_fuerte.";
}
?>