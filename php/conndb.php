<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexion a base de datos</title>
</head>

<body>
<?php
// Parámetros de conexión
$host     = 'localhost'; 
$port     = '5432'; 
$dbname   = 'food_mood'; 
$user     = 'postgres';
$password = 'Jorge#2005'; 

// Conexión a PostgreSQL usando PDO
try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos FOOD & MOOD.";
} catch (PDOException $e) {
    echo "Error: No se pudo conectar a la base de datos. " . $e->getMessage();
}
?>
</body>
</html>