<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['agregar-aperitivo']))
{
    $id_aperitivo     = null;
    $nombre_aperitivo = $_POST['nombre_aperitivo'];

    $stmt = $conn->prepare("INSERT INTO aperitivos (nombre_aperitivo) 
                            VALUES (:nombre_aperitivo)");
    $stmt->bindParam(':nombre_aperitivo', $nombre_aperitivo);
    if($stmt->execute())
    {
        header("Location: aperitivo.php");
    }
}
?>