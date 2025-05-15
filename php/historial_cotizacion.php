<?php
session_start();
include_once ('conndb.php');

if (!isset($_SESSION['correo'])) { 
    echo "<script>alert('Debes iniciar sesión para ver el historial de cotizaciones.'); 
            window.location.href = '../html/login.html';</script>";
    exit; 
    } 

$correo = $_SESSION['correo']; 
$sql = $conn->prepare(" SELECT *FROM usuario WHERE correo = :correo");
$sql->bindParam(':correo', $correo, PDO::PARAM_STR);
$sql->execute();
$result = $sql->fetch(PDO::FETCH_ASSOC); //obtenemos los datos del usuario

$id_usuario = $result['id_usuario']; //le asignamos el id_usuario a la variable

$stmt = $conn->prepare(" SELECT c.id_cotizacion,
                                        cl.nombre,
                                        cl.apellido, 
                                        p.nombre_paquete, 
                                        e.fecha_evento, 
                                        e.lugar_evento, 
                                        c.total
                                FROM cotizacion c 
                                INNER JOIN cliente cl ON c.fk_cliente = cl.id_cliente 
                                INNER JOIN paquete p  ON c.fk_paquete = p.id_paquete 
                                INNER JOIN evento e   ON c.fk_evento  = e.id_evento 
                                WHERE cl.fk_usuario = :id_usuario 
                                ORDER BY c.id_cotizacion DESC "); 
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">`
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/estilos_historialCotizaciones.css">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Historial de Cotizaciones</title>
</head>
<body>
    <header>
        <!-- Navigation-->
        <nav class="navbar-minimal">
            <div class="navbar-container">
                <a class="navbar-brand" href="../index.php" style="margin-left: 280px;">
                    <i class="fas fa-utensils"></i>
                    <span>FOOD & MOOD</span>
                </a>
                <a class="navbar-brand" href="https://github.com/JorgeMart-inez/Food_Mood_project">
                    <i class="fab fa-github"></i>
                    <span>Repositorio de F&M</span>
                </a>
                <a class="navbar-brand" href="https://github.com/JOGAMAT-desarrollo">
                    <i class="fas fa-user-tie"></i>
                    <span>JOGAMAT-desarrollo</span>
                </a>
            </div>
        </nav>
    </header>

    <section>
        <h1 class="titulo-table-cotizaciones">Lista de Cotizaciones de <?= $_SESSION['correo'] ?></h1>

        <table class="table-cotizaciones"> 
            <tr> 
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Paquete</th>
                <th>Fecha</th>
                <th>Lugar</th>
                <th>Total</th> 
            </tr> 
            <?php if (!empty($resultados)) { ?>
            <?php foreach ($resultados as $row) { ?>
                <tr>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['apellido'] ?></td>
                    <td><?= $row['nombre_paquete'] ?></td>
                    <td><?= $row['fecha_evento'] ?></td>
                    <td><?= $row['lugar_evento'] ?></td>
                    <td><?= $row['total'] ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php } else { ?>
            <tr>
                <td colspan="5">No hay cotizaciones disponibles.</td>
            </tr>
            <?php } ?>
        </table>                
    </section>

    <footer>
        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container px-4 px-lg-5">
                <div class="small text-center text-muted">Copyright &copy; 2025 - FOOD & MOOD</div>
            </div>
        </footer>
    </footer>

</body>
</html>