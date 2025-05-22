document.addEventListener('DOMContentLoaded', function () {
    //INICIO DEL EVENTO DE MODAL FLOTANTE EN DATOS PERSOANLES
    const botonAceptar = document.getElementById('aceptar');
    if (botonAceptar) {
        botonAceptar.addEventListener('click', function () {
        const modal = document.getElementById('datos-personales');
        if (modal) {
            modal.style.display = 'none';
            }
    });
}
    //FIN DEL EVENTO DE MODAL FLOTANTE EN DATOS PERSOANLES

});