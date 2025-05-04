<?php
//FUNCION PARA CARGAR LAS LIBRERIAS

function miAutoload($clase){
    $archivo = __DIR__ . '/../clases/' . basename(str_replace('\\', '/', $clase)) . '.php';
    if (file_exists($archivo)){
        require_once $archivo;
    }
}

//Registramos la funcion autoload
spl_autoload_register('miAutoload');
?>