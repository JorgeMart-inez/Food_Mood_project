<?php
    include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

    if(!empty($_POST['modificar-cliente']))
    {
        $id_cliente       = $_POST['id_cliente'];
        $nombre_cliente   = $_POST['nombre_cliente'];
        $apellido_cliente = $_POST['apellido_cliente'];
        $telefono_cliente = $_POST['telefono_cliente'];
        $estado_cliente   = $_POST['estado_cliente'];
        $fk_usuario       = $_POST['fk_usuario'];


        $stmt = $conn->prepare("UPDATE cliente SET nombre = :nombre_cliente, apellido = :apellido_cliente, 
                                telefono = :telefono_cliente, estado = :estado_cliente, fk_usuario = :fk_usuario 
                                WHERE id_cliente = :id_cliente");
        $stmt->bindParam(':id_cliente'        , $id_cliente);
        $stmt->bindParam(':nombre_cliente'    , $nombre_cliente);
        $stmt->bindParam(':apellido_cliente'  , $apellido_cliente);
        $stmt->bindParam(':telefono_cliente'  , $telefono_cliente);
        $stmt->bindParam(':estado_cliente'    , $estado_cliente);
        $stmt->bindParam(':fk_usuario'        , $fk_usuario);
        if($stmt->execute())
        {
            header("Location: cliente.php");
        }
    }
    else if(!empty($_POST['cancelar']))
    {
        header("Location: cliente.php");
    }
    else
    {
        echo "Error: No se pudo modificar el cliente.";
    }
    ?>