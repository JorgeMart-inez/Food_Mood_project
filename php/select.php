<?php
include('conndb.php');

echo "<link rel='stylesheet' href='..//CSS/estilos.css'>";
if(isset($_POST['cliente']))
{
    if(!empty($_POST['id_cliente']))
    {
        $id_cliente = ($_POST['id_cliente']);

        $stmt = $conn->prepare( "SELECT *
                                FROM cliente
                                WHERE id_cliente = :id_cliente");
        $stmt->bindParam('id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll();

       
        if((count($resultado)) > 0)
        {
            echo "<table border='1'>";
            echo "<h2 class='titulo-backend'>Resultado de busqueda:</h2>";
            echo "<tr><th>ID CLIENTE</th> <th>NOMBRE</th> <th>APELLIDO</th> <th>TELEFONO</th> <th>ESTADO</th></tr>";
            foreach ($resultado as $row){
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id_cliente']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nombre'])     . "</td>";
                echo "<td>" . htmlspecialchars($row['apellido'])   . "</td>";
                echo "<td>" . htmlspecialchars($row['telefono'])   . "</td>";
                echo "<td>" . htmlspecialchars($row['estado'])     . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
}
else if(isset($_POST['cotizacion']))
{
    if(!empty($_POST['id_cotizacion']))
    {
        $id_cotizacion = ($_POST['id_cotizacion']);

        $stmt = $conn->prepare("SELECT *
                                FROM cotizacion
                                WHERE id_cotizacion = :id_cotizacion");
        $stmt->bindParam(':id_cotizacion', $id_cotizacion, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($resultado) > 0){
            echo "<table border='1'>";
            echo "<tr> <th>ID COTIZACION</th> <th>ID PAQUETE</th> <th>TOTAL</th> </tr>";
            foreach ($resultado as $row){
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id_cotizacion']) . "</td>";
                echo "<td>" . htmlspecialchars($row['id_paquete'])    . "</td>";
                echo "<td>" . htmlspecialchars($row['total'])         . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else 
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>El ID buscado no existe, intente de nuevo por favor.</h2>";
        }
    }
    else
    {
        echo "<h2 font-family='Times New Roman, Sain, Serif'>Por favor rellene los campos!!</h2>";
    }
}
else if(isset($_POST['pago']))
{
    if(!empty($_POST['id_pago']))
    {
        $id_pago = ($_POST['id_pago']);

        $stmt = $conn->prepare("SELECT *
                                FROM pago
                                WHERE id_pago = :id_pago");
        $stmt->bindParam(':id_pago', $id_pago, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($resultado) > 0){
            echo "<table border='1'>";
            echo "<tr> <th>ID PAGO</th> <th>ID PAQUETE</th> <th>ID COPTIZACION</th> <th>ID USUARIO</th> <th>REFERENCIA</th> <th>PAGO TOTAL</th>
                  <th>METODO PAGO</th> <th>ESTADO DEL PAGO</th> <th>FECHA DE PAGO</th> <th>USUARIO</th> </tr>";
            foreach ($resultado as $row){
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id_pago'])         . "</td>";
                echo "<td>" . htmlspecialchars($row['id_paquete'])      . "</td>";
                echo "<td>" . htmlspecialchars($row['id_cotizacion'])   . "</td>";
                echo "<td>" . htmlspecialchars($row['id_usuario'])      . "</td>";
                echo "<td>" . htmlspecialchars($row['referencia_pago']) . "</td>";
                echo "<td>" . htmlspecialchars($row['total_pago'])      . "</td>";
                echo "<td>" . htmlspecialchars($row['metodo_pago'])     . "</td>";
                echo "<td>" . htmlspecialchars($row['estado_pago'])     . "</td>";
                echo "<td>" . htmlspecialchars($row['fecha_pago'])      . "</td>";
                echo "<td>" . htmlspecialchars($row['usuario'])         . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else 
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>El ID buscado no existe, intente de nuevo por favor.</h2>";
        }
    }
    else
    {
        echo "<h2 font-family='Times New Roman, Sain, Serif'>Por favor rellene los campos!!</h2>";
    }
}
else if(isset($_POST['paquete']))
{
    if(!empty($_POST['id_paquete']))
    {
        $id_paquete = ($_POST['id_paquete']);

        $stmt = $conn->prepare("SELECT *
                                FROM paquete
                                WHERE id_paquete = :id_paquete");
        $stmt->bindParam(':id_paquete', $id_paquete, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($resultado) > 0){
            echo "<table border='1'>";
            echo "<tr> <th>ID PAQUETE</th> <th>NOMBRE</th> <th>ANFITRION</th> <th>FECHA DE EVENTO</th>
                       <th>LUGAR DE EVENTO</th> <th>HORA</th> <th>DURACION</th> <th>INVITADOS</th> <th>TIPO EVENTO</th>
                       <th>SERVICIOS</th> <th>APERITIVO</th> <th>ENTRADA</th> <th>PLATO FUERTE</th> <th>POSTRE</th> <th>BEBIDA</th>
                       <th>METODO DE PAGO</th> <th>COSTO TOTAL</th>  </tr>";
            foreach ($resultado as $row){
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id_paquete'])         . "</td>";
                echo "<td>" . htmlspecialchars($row['nombre_paquete'])     . "</td>";
                echo "<td>" . htmlspecialchars($row['anfitrion'])          . "</td>";
                echo "<td>" . htmlspecialchars($row['fecha_evento'])       . "</td>";
                echo "<td>" . htmlspecialchars($row['lugar_evento'])       . "</td>";
                echo "<td>" . htmlspecialchars($row['hora_evento'])        . "</td>";
                echo "<td>" . htmlspecialchars($row['duracion_evento'])    . "</td>";
                echo "<td>" . htmlspecialchars($row['cantidad_invitados']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tipo_evento'])        . "</td>";
                echo "<td>" . htmlspecialchars($row['servicios'])          . "</td>";
                echo "<td>" . htmlspecialchars($row['aperitivo'])          . "</td>";
                echo "<td>" . htmlspecialchars($row['entrada'])            . "</td>";
                echo "<td>" . htmlspecialchars($row['plato_fuerte'])       . "</td>";
                echo "<td>" . htmlspecialchars($row['postre'])             . "</td>";
                echo "<td>" . htmlspecialchars($row['bebida'])             . "</td>";
                echo "<td>" . htmlspecialchars($row['metodo_pago'])        . "</td>";
                echo "<td>" . htmlspecialchars($row['total_costo'])        . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else 
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>El ID buscado no existe, intente de nuevo por favor.</h2>";
        }
    }
    else
    {
        echo "<h2 font-family='Times New Roman, Sain, Serif'>Por favor rellene los campos!!</h2>";
    }
}
else if(isset($_POST['usuario']))
{
    if(!empty($_POST['id_usuario']))
    {
        $id_usuario = ($_POST['id_usuario']);

        $stmt = $conn->prepare("SELECT id_usuario, correo, contrasenia
                                FROM usuario
                                WHERE id_usuario = :id_usuario");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($resultado) > 0){
            echo "<table border='1'>";
            echo "<tr> <th>ID USUARIO</th> <th>CORREO</th> <th>CONTRASEÑA</th> </tr>";
            foreach ($resultado as $row){
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id_usuario']) . "</td>";
                echo "<td>" . htmlspecialchars($row['correo'])     . "</td>";
                echo "<td>" . htmlspecialchars($row['contrasenia']). "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else 
        {
            echo "<h2 font-family='Times New Roman, Sain, Serif'>El ID buscado no existe, intente de nuevo por favor.</h2>";
        }
    }
    else
    {
        echo "<h2 font-family='Times New Roman, Sain, Serif'>Por favor rellene los campos!!</h2>";
    }
}
?>