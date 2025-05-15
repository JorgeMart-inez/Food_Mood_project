<?php
session_start();

$paquete = isset($_GET['paquete']) ? intval($_GET['paquete']) : 0;

//Define la redirección de cada paquete
$formulario = [
    1 => "../html/formu1.html",
    2 => "../html/formu2.html",
    3 => "../html/formu3.html",
    4 => "../html/formu4.html"
];

if (!isset($_SESSION['correo'])) {
    echo "<script>alert('Debes iniciar sesión para cotizar.'); window.location.href = '../html/login.html';</script>";
    exit;
} 
elseif (isset($_SESSION['correo']) && array_key_exists($paquete, $formulario)) {
    header("Location: " . $formulario[$paquete]);
    exit;
} 
else {
    echo "<script>alert('Paquete inválido.'); window.location.href = '../index.php';</script>";
    exit;
}

?>