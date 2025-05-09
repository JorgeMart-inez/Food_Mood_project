<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-usuario']))
{
    $id_usuario     = $_POST['id_usuario'];
    $correo_usuario = $_POST['correo_usuario'];
    $rol_usuario    = $_POST['rol_usuario'];

    $stmt = $conn->prepare("UPDATE usuario SET correo = :correo_usuario, rol = :rol_usuario 
                                    WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':id_usuario'    , $id_usuario);
    $stmt->bindParam(':correo_usuario', $correo_usuario);
    $stmt->bindParam(':rol_usuario'   , $rol_usuario);
    if($stmt->execute())
    {
        header("Location: usuario.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: usuario.php");
}
else
{
    echo "Error: No se pudo modificar el usuario.";
}
?>