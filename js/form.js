/* 
document.addEventListener('DOMContentLoaded', function() {
    // Obtener todos los botones de "Cotizar"
    const cotizarButtons = document.querySelectorAll('.modal_formulario');

    // Agregar un evento de clic a cada botón
    cotizarButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del enlace
            const href = this.getAttribute('href'); // Obtener el atributo href del botón
            window.location.href = href; // Redirigir a la URL especificada en el atributo href
        });
    });
});
*/

