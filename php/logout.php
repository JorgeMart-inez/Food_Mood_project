<?php
session_start();   //inicia la sesión del usuario
session_unset();   //Borra las variables de sesión
session_destroy(); //Destruye la sesión

header("Location: ../index.php");
exit();
?>