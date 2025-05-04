Hola, bienvenido al manual de uso de mi libreria!

Descripción--
Este proyecto contiene dos librerías PHP: una librería auxiliar y una librería principal. La librería auxiliar se encarga de calcular el costo total de los servicios seleccionados para un evento, mientras que la librería principal maneja el formato de pago y la generación de la referencia de pago.

--Librería Auxiliar (util)--
La librería auxiliar contiene funciones utilitarias que pueden ser usadas por la librería principal. En particular, la función más relevante es calc_costo_servicios, que calcula el costo total de los servicios seleccionados en función de un precio predefinido.

Funciones--
calc_costo_servicios($pServicios)

Parámetros:

$pServicios (array): Una lista de los servicios seleccionados por el usuario.
Descripción: Esta función toma un arreglo de servicios como entrada (como "cristaleria", "meseros", etc.) y calcula el costo total sumando los precios de los servicios seleccionados. Además, se agrega un costo base de 20,000 al total.

Retorno:

Devuelve el costo total de los servicios seleccionados, incluido el costo base de 20,000.

--Librería Principal (mi_libreria)
La librería principal se encarga de generar un formato de pago, que incluye los detalles del evento, los servicios seleccionados, y la referencia de pago única. También calcula el costo total tomando en cuenta los servicios seleccionados y la cantidad de invitados.

Funciones--
formato($pPaquete, $pNombre, $pEvento, $pLugar, $pFecha, $pHora, $pDuracion, $pInvitados, $pServicios_str, $pAperitivo, $pEntrada, $pPlato, $pBebida, $pMetodo, $pServicios)

Parámetros:

$pPaquete (string): El nombre del paquete seleccionado.
$pNombre (string): El nombre del anfitrión.
$pEvento (string): El tipo de evento (por ejemplo, boda, cumpleaños).
$pLugar (string): El lugar del evento.
$pFecha (string): La fecha del evento.
$pHora (string): La hora del evento.
$pDuracion (int): La duración del evento en horas.
$pInvitados (int): El número de invitados.
$pServicios_str (string): Una cadena con los servicios seleccionados (por ejemplo, "cristaleria, meseros").
$pAperitivo (string): El aperitivo seleccionado.
$pEntrada (string): La entrada seleccionada.
$pPlato (string): El plato principal seleccionado.
$pBebida (string): La bebida seleccionada.
$pMetodo (string): El método de pago (por ejemplo, tarjeta de crédito).
$pServicios (array): Un arreglo de los servicios seleccionados (como "cristaleria", "meseros", etc.).
Descripción: Esta función genera el formato de pago para el paquete seleccionado. Muestra los detalles del evento, los servicios y las opciones de comida. También calcula el costo total, que incluye el costo de los servicios y los invitados, y genera una referencia de pago única.

Retorno:

No devuelve un valor, pero imprime en pantalla el formato de pago con todos los detalles.
Uso
1. Incluir las librerías
Para usar las funciones de estas librerías, primero debes incluirlas en tu archivo PHP. Asegúrate de usar el namespace adecuado al incluirlas, de lo contrario tendras demasiados errores.

// Incluir la librería auxiliar
require_once 'path/to/util.php';

// Incluir la librería principal
require_once 'path/to/mi_libreria.php';
2. Crear una instancia de mi_libreria

use mi_libreria\mi_libreria;

$miLibreria = new mi_libreria();
3. Llamar a la función formato()
Después de crear una instancia de mi_libreria, puedes llamar a la función formato() para generar el formato de pago. Asegúrate de pasarle los parámetros requeridos, de lo contrario generará un error.


$miLibreria->formato(
    "Paquete Básico",       // Paquete
    "Juan Pérez",           // Nombre
    "Boda",                 // Evento
    "Plaza Mayor",          // Lugar
    "2025-06-15",           // Fecha
    "18:00",                // Hora
    5,                      // Duración (horas)
    100,                    // Invitados
    "cristaleria, meseros", // Servicios como cadena de texto
    "Ensalada",             // Aperitivo
    "Sopa de pollo",        // Entrada
    "Filete",               // Plato fuerte
    "Vino",                 // Bebida
    "Tarjeta de crédito",   // Método de pago
    ["cristaleria", "meseros"]  // Servicios como arreglo
);
4. Resultado
La función imprimirá una tabla con todos los detalles del evento, incluyendo el nombre del anfitrión, la fecha, el tipo de evento, los servicios seleccionados, el total a pagar y una referencia de pago única.

--Archivo 'autoload.php' (autoload)--

Este archivo contiene una función de autoload en PHP. La función miAutoload permite cargar las clases de manera automática cuando son necesarias, sin necesidad de incluir manualmente cada archivo de clase con require o include. El sistema busca los archivos de clase en un directorio específico y los carga cuando se hace referencia a la clase en el código.

Función
miAutoload($clase)

Parámetros:

$clase (string): El nombre completo de la clase (incluido el namespace, si existe).
Descripción: La función miAutoload toma el nombre de una clase que se está intentando usar, convierte el namespace en una ruta válida para buscar el archivo correspondiente en el sistema de archivos, y luego incluye ese archivo si existe. El archivo debe estar ubicado en el directorio ../clases/ (relativo al directorio del archivo que llama la función).

Proceso:

La función busca el archivo de la clase en el directorio ../clases/ y en su ruta convertida a partir del nombre completo de la clase.
Si el archivo existe, lo carga usando require_once.
spl_autoload_register('miAutoload')
Descripción:

Esta línea registra la función miAutoload como un manejador de autoload, de modo que PHP la invoca automáticamente cuando se intenta acceder a una clase que aún no ha sido definida.
Uso
1. Incluir el archivo de autoload
Para usar el autoload, simplemente incluye este archivo al inicio de tu script PHP. Esto garantizará que las clases se carguen automáticamente cuando sean necesarias.

require_once 'path/to/miAutoload.php';
2. Crear una clase
Asegúrate de que las clases que estás creando estén dentro de un namespace y estén ubicadas en el directorio correcto (../clases/). Aquí hay un ejemplo básico de una clase:

namespace mi_libreria;

class MiClase {
    public function saludo() {
        return "¡Hola desde MiClase!";
    }
}
El archivo correspondiente para esta clase debe estar en la ruta:

bash
Copiar
Editar
../clases/mi_libreria/MiClase.php
3. Utilizar la clase
Ahora, puedes instanciar la clase directamente sin necesidad de incluir su archivo explícitamente:

use mi_libreria\MiClase;

$miClase = new MiClase();
echo $miClase->saludo();
PHP automáticamente buscará y cargará el archivo correspondiente gracias al autoload.

--Requisitos--
PHP 7 o superior.
Un servidor web como Apache o Nginx para ejecutar el código PHP, xampp funciona bien.
Contribuciones
Si deseas contribuir a este proyecto, puedes hacerlo a través de un pull request. Asegúrate de seguir las mejores prácticas de programación y escribir pruebas para cualquier nueva funcionalidad que agregues.


Si te interesa saber mas al respecto de esta libreria, pasa por mi...
Organizacion de GitHub: https://github.com/JOGAMAT-desarrollo