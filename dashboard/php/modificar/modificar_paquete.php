<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

if(!empty($_POST['modificar-paquete']))
{
    $id_paquete      = $_POST['id_paquete'];
    $nombre_paquete  = $_POST['nombre_paquete'];
    $anfitrion       = $_POST['anfitrion'];
    $fk_evento       = $_POST['fk_evento'];
    $fk_aperitivo    = $_POST['fk_aperitivo'];
    $fk_entrada      = $_POST['fk_entrada'];
    $fk_plato_fuerte = $_POST['fk_plato_fuerte'];
    $fk_postre       = ($_POST['fk_postre'] === '' || !isset($_POST['fk_postre'])) ? null : $_POST['fk_postre'];
    $fk_bebida       = $_POST['fk_bebida'];
    $fk_metodo_pago  = $_POST['fk_metodo_pago'];

    $stmt = $conn->prepare("UPDATE paquete 
                                    SET nombre_paquete  = :nombre_paquete, 
                                        anfitrion       = :anfitrion, 
                                        fk_evento       = :fk_evento, 
                                        fk_aperitivo    = :fk_aperitivo, 
                                        fk_entrada      = :fk_entrada, 
                                        fk_plato_fuerte = :fk_plato_fuerte, 
                                        fk_postre       = :fk_postre, 
                                        fk_bebida       = :fk_bebida, 
                                        fk_metodo_pago  = :fk_metodo_pago 
                                    WHERE id_paquete = :id_paquete");
    $stmt->bindParam(':id_paquete'      , $id_paquete     , PDO::PARAM_INT);
    $stmt->bindParam(':nombre_paquete'  , $nombre_paquete , PDO::PARAM_STR);
    $stmt->bindParam(':anfitrion'       , $anfitrion      , PDO::PARAM_STR);
    $stmt->bindParam(':fk_evento'       , $fk_evento      , PDO::PARAM_INT);
    $stmt->bindParam(':fk_aperitivo'    , $fk_aperitivo   , PDO::PARAM_INT);
    $stmt->bindParam(':fk_entrada'      , $fk_entrada     , PDO::PARAM_INT);
    $stmt->bindParam(':fk_plato_fuerte' , $fk_plato_fuerte, PDO::PARAM_INT);
    if ($fk_postre === null) {
    $stmt->bindValue(':fk_postre', null, PDO::PARAM_NULL);
    } 
    else {
    $stmt->bindValue(':fk_postre', $fk_postre, PDO::PARAM_INT);
    }

    $stmt->bindParam(':fk_bebida'       , $fk_bebida      , PDO::PARAM_INT);
    $stmt->bindParam(':fk_metodo_pago'  , $fk_metodo_pago , PDO::PARAM_INT);
    if($stmt->execute())
    {
        header("Location: ../paquete.php");
    }
}
else if(!empty($_POST['cancelar']))
{
    header("Location: ../paquete.php");
}
else
{
    echo "Error: No se pudo modificar el paquete.";
}
?>