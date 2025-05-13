<?php
include_once 'D:\Xampp\htdocs\F&M_version1.7.1\php\conndb.php';

// Inicializa los filtros
$id_cliente_filter       = isset($_POST['id_cliente_filter'])       ? $_POST['id_cliente_filter']       : '';
$nombre_cliente_filter   = isset($_POST['nombre_cliente_filter'])   ? $_POST['nombre_cliente_filter']   : '';
$apellido_cliente_filter = isset($_POST['apellido_cliente_filter']) ? $_POST['apellido_cliente_filter'] : '';
$telefono_cliente_filter = isset($_POST['telefono_cliente_filter']) ? $_POST['telefono_cliente_filter'] : '';
$estado_cliente_filter   = isset($_POST['estado_cliente_filter'])   ? $_POST['estado_cliente_filter']   : '';
$fk_usuario_filter       = isset($_POST['fk_usuario_filter'])       ? $_POST['fk_usuario_filter']       : '';


// Construye la consulta SQL con filtros
$query = "SELECT * FROM cliente WHERE 1=1";

if (!empty($id_cliente_filter)) {
    $query .= " AND id_cliente = :id_cliente_filter";
}
if (!empty($nombre_cliente_filter)) {
    $query .= " AND nombre LIKE :nombre_cliente_filter";
}
if (!empty($apellido_cliente_filter)) {
    $query .= " AND apellido LIKE :apellido_cliente_filter";
}
if (!empty($telefono_cliente_filter)) {
    $query .= " AND telefono = :telefono_cliente_filter";
}
if (!empty($estado_cliente_filter)) {
    $query .= " AND estado = :estado_cliente_filter";
}
if (!empty($fk_usuario_filter)) {
    $query .= " AND fk_usuario = :fk_usuario_filter";
}

$stmt = $conn->prepare($query);

// Asigna los valores a los parámetros
if (!empty($id_cliente_filter)) {
    $stmt->bindParam(':id_cliente_filter', $id_cliente_filter, PDO::PARAM_INT);
}
if (!empty($nombre_cliente_filter)) {
    $stmt->bindValue(':nombre_cliente_filter', '%' . $nombre_cliente_filter . '%', PDO::PARAM_STR);
}
if (!empty($apellido_cliente_filter)) {
    $stmt->bindValue(':apellido_cliente_filter', '%' . $apellido_cliente_filter . '%', PDO::PARAM_STR);
}
if (!empty($telefono_cliente_filter)) {
    $stmt->bindParam(':telefono_cliente_filter', $telefono_cliente_filter, PDO::PARAM_STR);
}
if (!empty($estado_cliente_filter)) {
    $stmt->bindParam(':estado_cliente_filter', $estado_cliente_filter, PDO::PARAM_STR);
}
if (!empty($fk_usuario_filter)) {
    $stmt->bindParam(':fk_usuario_filter', $fk_usuario_filter, PDO::PARAM_INT);
}

// Ejecuta la consulta
$stmt->execute();

// Muestra los resultados
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tabla Prin. Usuario</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="http://localhost/F&M_version1.7.1/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        
    <!-- Custom styles for this template-->
    <link href="http://localhost/F&M_version1.7.1/dashboard/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="http://localhost/F&M_version1.7.1/dashboard/css/sb-admin-dash.css" rel="stylesheet">
    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="http://localhost/F&M_version1.7.1/dashboard/index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Food & Mood Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="http://localhost/F&M_version1.7.1/dashboard/index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Tablas Principales Collapse Menu-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-database"></i>
                    <span>Tablas Principales</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Entidades fuertes:</h6>
                        <a class="collapse-item" href="usuario.php">Usuario</a>
                        <a class="collapse-item" href="cliente.php">Cliente</a>
                        <a class="collapse-item" href="evento.php">Evento</a>
                        <a class="collapse-item" href="paquete.php">Paquete</a>
                        <a class="collapse-item" href="paquete_servicio.php">paquete_servicio</a>
                        <a class="collapse-item" href="datos_pago.php">Datos de Pago</a>
                        <a class="collapse-item" href="pago.php">Pago</a>
                        <a class="collapse-item" href="cotizacion.php">Cotización</a>
                    </div>
                </div>
            </li>

            <!--Nav Item - Tablas Auxiliares Collapse Menu-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAux"
                    aria-expanded="true" aria-controls="collapseAux">
                    <i class="fa fa-table"></i>
                    <span>Tablas Auxiliares</span>
                </a>
                <div id="collapseAux" class="collapse" aria-labelledby="headingAux" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Entidades:</h6>
                        <a class="collapse-item" href="aperitivo.php">Aperitivo</a>
                        <a class="collapse-item" href="entrada.php">Entrada</a>
                        <a class="collapse-item" href="plato_fuerte.php">Plato Fuerte</a>
                        <a class="collapse-item" href="postre.php">Postre</a>
                        <a class="collapse-item" href="bebida.php">Bebidas</a>
                        <a class="collapse-item" href="servicios.php">Servicios</a>
                        <a class="collapse-item" href="metodo_pago.php">Método de Pago</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilidades</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Utilidades Custom:</h6>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/utilities-color.html">Colores</a>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/utilities-border.html">Bordes</a>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/utilities-animation.html">Animaciones</a>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/buttons.html">Botones</a>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/cards.html">Cards</a>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/utilities-other.html">Otras</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Complementos
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Páginas</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ventanas de Sesión:</h6>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/login.html">Login</a>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/register.html">Singin</a>
                        <a class="collapse-item" href="#">Olvidé mi contraseña</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Otras Ventanas:</h6>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/404.html">404 Screen</a>
                        <a class="collapse-item" href="http://localhost/F&M_version1.7.1/dashboard/blank.html">Página en Blanco</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="http://localhost/F&M_version1.7.1/dashboard/charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Gráficas</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notificaciones
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Diciembre 12, 2023</div>
                                        <span class="font-weight-bold">El reporte del mes está listo!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Diciembre 7, 2023</div>
                                        $290.29 ha sido depositado en tu cuenta!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2023</div>
                                        Alerta de gasto: Hemos notado un gasto inusualmente alto en su cuenta.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Todas las notificaciones</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Mensajes
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="http://localhost/F&M_version1.7.1/dashboard/img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">¡Hola! Me gustaría saber si pueden ayudarme con un evento.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="http://localhost/F&M_version1.7.1/dashboard/img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Tengo las fotos que pediste el mes pasado, ¿cómo te gustaría que te las enviaran?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="http://localhost/F&M_version1.7.1/dashboard/img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">El informe del mes pasado se ve genial. Estoy muy contento con el progreso hasta ahora. ¡Sigan con el buen trabajo!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Leer más</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="http://localhost/F&M_version1.7.1/dashboard/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configuraciones
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Actividad
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Filter Menu -->
                    <form action="filtrar_cliente.php" method="POST" autocomplete="off" class="filtro-container">
                        
                        <button id="btnFiltro" class="btn-filtro" title="Filtrar">
                        <i class="fas fa-filter"></i>
                        </button>

                        <div id="panelFiltro" class="panel-filtro">

                            <label for="id_cliente_filter">ID Cliente:</label>
                            <input type="number" name="id_cliente_filter" id="id_cliente_filter" placeholder="Buscar por ID" />

                            <label for="nombre_cliente_filter">Nombre Cliente:</label>
                            <input type="text" name="nombre_cliente_filter" id="nombre_cliente_filter" placeholder="Buscar por Nombre" />

                            <label for="apellido_cliente_filter">Apellido Cliente:</label>
                            <input type="text" name="apellido_cliente_filter" id="apellido_cliente_filter" placeholder="Buscar por Apellido" />

                            <label for="telefono_cliente_filter">Teléfono Cliente:</label>
                            <input type="tel" name="telefono_cliente_filter" id="telefono_cliente_filter" minlength="10" maxlength="10" placeholder="Buscar por Teléfono" />

                            <label for="estado_cliente_filter">Estado en el que radica:</label>
                            <select name="estado_cliente_filter" id="estado_cliente_filter">
                                <option value="" disabled selected>Seleccione su estado</option>
                                <option value="Aguascalientes">Aguascalientes</option>
                                <option value="Baja California">Baja California</option>
                                <option value="Baja California Sur">Baja California Sur</option>
                                <option value="Campeche">Campeche</option>
                                <option value="Chiapas">Chiapas</option>
                                <option value="Chihuahua">Chihuahua</option>
                                <option value="Coahuila">Coahuila</option>
                                <option value="Colima">Colima</option>
                                <option value="Ciudad de México">Ciudad de México</option>
                                <option value="Durango">Durango</option>
                                <option value="Estado de México">Estado de México</option>
                                <option value="Guanajuato">Guanajuato</option>
                                <option value="Guerrero">Guerrero</option>
                                <option value="Hidalgo">Hidalgo</option>
                                <option value="Jalisco">Jalisco</option>
                                <option value="Michoacán">Michoacán</option>
                                <option value="Morelos">Morelos</option>
                                <option value="Nayarit">Nayarit</option>
                                <option value="Nuevo León">Nuevo León</option>
                                <option value="Oaxaca">Oaxaca</option>
                                <option value="Puebla">Puebla</option>
                                <option value="Querétaro">Querétaro</option>
                                <option value="Quintana Roo">Quintana Roo</option>
                                <option value="San Luis Potosí">San Luis Potosí</option>
                                <option value="Sinaloa">Sinaloa</option>
                                <option value="Sonora">Sonora</option>
                                <option value="Tabasco">Tabasco</option>
                                <option value="Tamaulipas">Tamaulipas</option>
                                <option value="Tlaxcala">Tlaxcala</option>
                                <option value="Veracruz">Veracruz</option>
                                <option value="Yucatán">Yucatán</option>
                                <option value="Zacatecas">Zacatecas</option>
                            </select>

                            <label for="fk_usuario_filter">FK del Usuario: </label>
                            <input type="number" name="fk_usuario_filter" id="fk_usuario_filter" placeholder="Buscar por FK de Usuario" />

                            <input type="submit" name="filtrar-cliente" value="Filtrar" class="btn-filter" />
                        </div>
                    </form>
                    <!-- End of Filter Menu -->

                    <!-- Page Heading -->
                    <div class="titulo-table-dash-container">
                        <h1 class="title-maintable-dash">TABLA PRINCIPAL: CLIENTE</h1>
                    </div>

                    <!-- Botón flotante -->
                    <button id="boton-flotante" class="boton-flotante">+</button>

                    <!-- Contenedor del formulario oculto -->
                    <div id="formulario-flotante" class="contenedor-formulario oculto">
                        <form action="insert.php" autocomplete="off" method="POST" class="formulario-maintable-dash">
                            <label for="nombre_cliente">Nombre(s): </label>
                            <input type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre del Cliente">

                            <label for="apellido_cliente">Apellido(s): </label> 
                            <input type="text" name="apellido_cliente" id="apellido_cliente" placeholder="Apellido(s) del Cliente">

                            <label for="telefono_cliente">No. Teléfono: </label>
                            <input type="text" name="telefono_cliente" id="telefono_cliente" minlength="10" maxlength="10" placeholder="Teléfono del Cliente">

                            <label for="estado_cliente">Estado en el que radica:</label>
                            <select name="estado_cliente" id="estado_cliente">
                                <option value="" disabled selected>Seleccione su estado</option>
                                <option value="Aguascalientes">Aguascalientes</option>
                                <option value="Baja California">Baja California</option>
                                <option value="Baja California Sur">Baja California Sur</option>
                                <option value="Campeche">Campeche</option>
                                <option value="Chiapas">Chiapas</option>
                                <option value="Chihuahua">Chihuahua</option>
                                <option value="Coahuila">Coahuila</option>
                                <option value="Colima">Colima</option>
                                <option value="Ciudad de México">Ciudad de México</option>
                                <option value="Durango">Durango</option>
                                <option value="Estado de México">Estado de México</option>
                                <option value="Guanajuato">Guanajuato</option>
                                <option value="Guerrero">Guerrero</option>
                                <option value="Hidalgo">Hidalgo</option>
                                <option value="Jalisco">Jalisco</option>
                                <option value="Michoacán">Michoacán</option>
                                <option value="Morelos">Morelos</option>
                                <option value="Nayarit">Nayarit</option>
                                <option value="Nuevo León">Nuevo León</option>
                                <option value="Oaxaca">Oaxaca</option>
                                <option value="Puebla">Puebla</option>
                                <option value="Querétaro">Querétaro</option>
                                <option value="Quintana Roo">Quintana Roo</option>
                                <option value="San Luis Potosí">San Luis Potosí</option>
                                <option value="Sinaloa">Sinaloa</option>
                                <option value="Sonora">Sonora</option>
                                <option value="Tabasco">Tabasco</option>
                                <option value="Tamaulipas">Tamaulipas</option>
                                <option value="Tlaxcala">Tlaxcala</option>
                                <option value="Veracruz">Veracruz</option>
                                <option value="Yucatán">Yucatán</option>
                                <option value="Zacatecas">Zacatecas</option>
                            </select>

                            <label for="fk_usuario">ID del Usuario al que pertenece:</label>
                            <input type="number" name="fk_usuario" id="fk_usuario" placeholder="ID del usuario">

                            <input type="submit" name="agregar-cliente" class="btn btn-sm btn-success" value="Ingresar Cliente">
                        </form>
                    </div>

                    <!-- End of Page Heading -->

                    <!-- Table Content-Operations -->

                    <div>
                        <h3 class="titulo-table-dash">Lista de Clientes</h3>
                        <table class="table-dashboard">
                            <thead>
                                <tr>
                                    <th>ID Cliente</th>
                                    <th>Nombre(s)</th>
                                    <th>Apellido(s)</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>FK Usuario</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($resultados)): ?>
                                    <?php foreach ($resultados as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id_cliente']) ?></td>
                                            <td><?= htmlspecialchars($row['nombre']) ?></td>
                                            <td><?= htmlspecialchars($row['apellido']) ?></td>
                                            <td><?= htmlspecialchars($row['telefono']) ?></td>
                                            <td><?= htmlspecialchars($row['estado']) ?></td>
                                            <td><?= htmlspecialchars($row['fk_usuario']) ?></td>
                                            <th><form action=""><a name="modificar-cliente" class="btn btn-sm btn-primary shadow-sm" href="update_cliente.php?id_cliente=<?= $row['id_cliente']?>">Modificar</a></form></th>
                                            <th><button type="button" class="btn btn-sm btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEliminar<?= $row['id_cliente'] ?>">
                                                    Eliminar
                                                </button>
                                                <div class="modal fade" id="modalEliminar<?= $row['id_cliente'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $row['id_cliente'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title" id="modalLabel<?= $row['id_cliente'] ?>">¿Estás seguro?</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                            </div>
                                                                <div class="modal-body">
                                                                    Esta acción eliminará el cliente <strong><?= $row['nombre'] . " " . $row['apellido']?></strong>. Esta operación no se puede deshacer.
                                                                </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <a href="delete_cliente.php?id_cliente=<?= $row['id_cliente'] ?>" class="btn btn-danger">Eliminar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No se encontraron resultados.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!--End of Table Content-Operations -->
                
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2025 - FOOD & MOOD</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Logout" si estás seguro de cerrar la sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="http://localhost/F&M_version1.7.1/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="http://localhost/F&M_version1.7.1/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="http://localhost/F&M_version1.7.1/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="http://localhost/F&M_version1.7.1/dashboard/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="http://localhost/F&M_version1.7.1/dashboard/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="http://localhost/F&M_version1.7.1/dashboard/js/demo/chart-area-demo.js"></script>
    <script src="http://localhost/F&M_version1.7.1/dashboard/js/demo/chart-pie-demo.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for the filter btn and insert btn -->
    <script src="http://localhost/F&M_version1.7.1/dashboard/js/scripts.js"></script>

</body>

</html>