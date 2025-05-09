    <?php
    include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

    if(!empty($_POST['modificar-servicio']))
    {
        $id_servicio     = $_POST['id_servicio'];
        $nombre_servicio = $_POST['nombre_servicio'];
        $precio_servicio = $_POST['precio_servicio'];

        $stmt = $conn->prepare("UPDATE servicios SET nombre_servicio = :nombre_servicio, 
                                    precio_servicio = :precio_servicio WHERE id_servicio = :id_servicio");
        $stmt->bindParam(':id_servicio', $id_servicio);
        $stmt->bindParam(':nombre_servicio', $nombre_servicio);
        $stmt->bindParam(':precio_servicio', $precio_servicio);
        if($stmt->execute())
        {
            header("Location: servicios.php");
        }
    }
    else if(!empty($_POST['cancelar']))
    {
        header("Location: servicios.php");
    }
    else
    {
        echo "Error: No se pudo modificar el servicio.";
    }
    ?>