<?php
    include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

    if(!empty($_POST['modificar-evento']))
    {
        $id_evento          = $_POST['id_evento'];
        $fecha_evento       = $_POST['fecha_evento'];
        $lugar_evento       = $_POST['lugar_evento'];
        $hora_evento        = $_POST['hora_evento'];
        $duracion_evento    = $_POST['duracion_evento'];
        $cantidad_invitados = $_POST['cantidad_invitados'];
        $tipo_evento        = $_POST['tipo_evento'];


        $stmt = $conn->prepare("UPDATE evento SET fecha_evento = :fecha_evento, lugar_evento = :lugar_evento,
                                hora_evento = :hora_evento, duracion_evento = :duracion_evento, 
                                cantidad_invitados = :cantidad_invitados, tipo_evento = :tipo_evento
                                WHERE id_evento = :id_evento");
                                
        $stmt->bindParam(':id_evento'          , $id_evento);
        $stmt->bindParam(':fecha_evento'       , $fecha_evento);
        $stmt->bindParam(':lugar_evento'       , $lugar_evento);
        $stmt->bindParam(':hora_evento'        , $hora_evento);
        $stmt->bindParam(':duracion_evento'    , $duracion_evento);
        $stmt->bindParam(':cantidad_invitados' , $cantidad_invitados);
        $stmt->bindParam(':tipo_evento'        , $tipo_evento);

        if($stmt->execute())
        {
            header("Location: ../evento.php");
        }
    }
    else if(!empty($_POST['cancelar']))
    {
        header("Location: ../evento.php");
    }
    else
    {
        echo "Error: No se pudo modificar el evento.";
    }
    ?>