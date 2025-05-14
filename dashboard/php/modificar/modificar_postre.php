<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-postre']))
{
    $id_postre     = $_POST['id_postre'];
    $nombre_postre = $_POST['nombre_postre'];

    $stmt = $conn->prepare("UPDATE postres SET nombre_postre = :nombre_postre WHERE id_postre = :id_postre");
    $stmt->bindParam(':id_postre', $id_postre);
    $stmt->bindParam(':nombre_postre', $nombre_postre);
    if($stmt->execute())
    {
        header("Location: ../postre.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../postre.php");
}
else
{
    echo "Error: No se pudo modificar el postre.";
}
?>