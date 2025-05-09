btnFiltro.addEventListener('click', (e) => {
    e.preventDefault(); // <-- esto evita que el formulario se envíe
    const isOpen = panelFiltro.style.display === 'block';
    panelFiltro.style.display = isOpen ? 'none' : 'block';
    btnFiltro.classList.toggle('rotar', !isOpen);
});

const boton = document.getElementById('boton-flotante');
    const formulario = document.getElementById('formulario-flotante');

    boton.addEventListener('click', () => {
        formulario.classList.toggle('oculto');
    });