<?php
session_start();
include('conndb.php');

if (isset($_POST['login'])) {
    $correo      = $_POST['correo'];
    $contrasenia = $_POST['contrasenia'];

    // Consulta para obtener el usuario
    $sql  = "SELECT * FROM usuario WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasenia, $usuario['contrasenia'])) 
    {
        if($usuario['rol'] === 'admin')
        {
            $_SESSION['admin']      = true;
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            echo "<script>
            alert('Bienvenido Administrador');
            window.location.href = '../php/menu_admin.php';
                </script>";
        exit();
        }
        else
        {
            // Inicio de sesión exitoso
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['correo']     = $usuario['correo'];
            echo "<script>
            alert('Bienvenido $correo');
            window.location.href = '../index.html';
                </script>";
        exit();
        }
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href='../html/login.html';</script>";
    }
}
?>