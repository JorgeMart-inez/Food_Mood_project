<?php
include('conndb.php');

if (isset($_POST['singup']))
{
    $correo       = $_POST['correo'];
    $contrasenia1 = $_POST['contrasenia1'];
    $contrasenia2 = $_POST['contrasenia2'];

    if($contrasenia1 !== $contrasenia2)
    {
        echo "<script>alert('Las contraseñas no coinciden'); window.location.href='../html/singup.html';</script>";
        exit();
    }   
    
    $sql = "SELECT * FROM usuario WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();

    if ($stmt->fetch()) 
    {
        echo "<script>alert('Ya existe una cuenta con este correo.'); window.location.href='../html/signup.html';</script>";
        exit();
    }

    $hashed_password = password_hash($contrasenia1, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO usuario (correo, contrasenia) VALUES (:correo, :contrasenia)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bindParam(':correo', $correo);
    $stmt_insert->bindParam(':contrasenia', $hashed_password);
    $stmt_insert->execute();

    $id_usuario = $conn->lastInsertId();
    session_start();    
    $_SESSION['id_usuario'] = $id_usuario;
    echo "<script>alert('Cuenta creada correctamente. Inicia sesión.'); window.location.href='../html/datos_personales.html';</script>";
}
?>