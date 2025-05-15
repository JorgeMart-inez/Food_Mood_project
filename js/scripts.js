
//EVENTO DE BOOSTRAP
window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () 
    {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) 
    {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

   
    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // Activate SimpleLightbox plugin for portfolio items
    new SimpleLightbox({
        elements: '#portfolio a.portfolio-box'
    });


    //Evento de slides
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });


    //Evento de paquetes
    const openModals = document.querySelectorAll('.card_abierta'); // Selecciona todos los botones
    const modal      = document.querySelector('.modal');
    const closeModal = document.querySelector('.modal_close');

    // Elementos dentro del modal para modificar dinámicamente
    const modalImg       = document.querySelector('.modal_img');
    const modalTitle     = document.querySelector('.modal_tittle');
    const modalParagraph = document.querySelector('.modal_paragraph');
    const modalA         = document.querySelector('.modal_formulario');

    // Agrega evento de clic a cada botón
    openModals.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            // Encuentra la tarjeta a la que pertenece el botón
            const card = button.closest('.card');

            // Extrae la información de la tarjeta
            const imgSrc      = card.querySelector('img').src;
            const title       = card.querySelector('h3').textContent;
            const description = card.querySelector('p').textContent;
            const id          = card.querySelector('a').dataset.id;

            // Actualiza el contenido del modal
            modalImg.src               = imgSrc;
            modalTitle.textContent     = title;
            modalParagraph.textContent = description;
            modalA.href = 'php/verificar_cotizacion.php?paquete=' + id; 

            // Muestra el modal
            modal.classList.add('modal--show');
        });
    });

    // Evento para cerrar el modal
    closeModal.addEventListener('click', (e) => {
        e.preventDefault();
        modal.classList.remove('modal--show');
    });

    //FIN DEL EVENTO DE PAQUETES

    //INICIO DEL EVENTO DE VALIDACION DE CONTRASEÑAS EN SINGUP
    document.querySelector("#singup-form").addEventListener("submit", function(event){
        let contrasenia_uno = document.getElementById("contrasenia1").value;
        let contrasenia_dos = document.getElementById("contrasenia2").value;

        if(contrasenia_uno != contrasenia_dos){
            event.preventDefault();
            alert("Las contraseñas no coinciden");
        }
    })
    //FIN DEL EVENTO DE VALIDACION DE CONTRASEÑAS EN SINGUP

});

    
