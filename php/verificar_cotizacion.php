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
    echo "<div class='alerta' id='alerta'>
            <strong>⚠️ Advertencia:</strong> Debes iniciar sesión para cotizar.
        </div>
    <script>
        setTimeout(function() {
            window.location.href = '../html/login.html';
        }, 2500);
        </script>
    <style>
        .alerta {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: rgb(232, 83, 83);
        color: #222;
        padding: 15px;
        text-align: center;
        font-weight: bold;
        z-index: 9999;
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        font-family: Arial, sans-serif;
        }
    </style>";
    
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