<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="Joji Dev" />
    <title>FOOD & MOOD</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- SimpleLightbox plugin CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- SimpleLightbox plugin JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!--Enlaces a js y css-->
    <script src="../F&M_version1.7.1/js/scripts.js" defer></script>
    <link rel="stylesheet" href="../F&M_version1.7.1/css/styles.css">
</head>

<body id="page-top">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">
                <i class="fas fa-utensils me-2"></i> FOOD & MOOD
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#about">
                        <i class="fa fa-users me-2" aria-hidden="true"></i>Nosotros
                    </a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">
                        <i class="fas fa-wine-glass-alt me-2"></i>Paquetes
                    </a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">
                        <i class="fas fa-book-open me-2"></i>Eventos Realizados
                    </a></li>
                    <li class="nav-item"><a href="../F&M_version1.7.1/php/historial_cotizacion.php" class="nav-link">
                        <i class="fas fa-history me-2"></i>Historial de Cotizaciones
                    </a></li>
                    <?php
                    session_start();
                    if (isset($_SESSION['correo'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-user-circle me-2" aria-hidden="true"></i>'.$_SESSION['correo'].'</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="../F&M_version1.7.1/php/logout.php"><i class="fa fa-sign-out-alt me-2" aria-hidden="true"></i>Cerrar Sesión</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="../F&M_version1.7.1/html/login.html"><i class="fa fa-user-circle me-2" aria-hidden="true"></i>Iniciar Sesión</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-cursive">"Organizamos eventos, creamos recuerdos"</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">Nuestra prioridad es brindar el mejor servicio, limpio, completo y
                        delicioso.</p>
                    <a class="btn btn-primary btn-xl" href="#about">Saber Más</a>
                </div>
            </div>
        </div>
    </header>

    <!-- About-->
    <section class="page-section bg-primary" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">Organizando a la altura de la espectativa</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-75 mb-4">En Food & Mood priorizamos la satisfacción del cliente, de manera que
                        brindamos diversos servicios, como mantelería, cristalería, servicio de meseros, entre otros, y,
                        en esencia, servicios alimenticios con diversos estilos, como lo es nuestro menú a 3 tiempos,
                        Buffet, Barra fría y demás!. Dichos servicios van de la mano con las peticiones del cliente,
                        propiciando así, un servicio de excelencia. Por ello, FOOD & MOOD es la empresa predilecta para
                        organizar tus eventos y crear lindos recuerdos.</p>
                    <a class="btn btn-light btn-xl" href="#services">¡Comencemos!</a>
                </div>
            </div>
        </div>
    </section>
   

    <section class="page-section" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">Selecciona un Paquete</h2>
            <hr class="divider" />
            <div class="contenedor">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <!-- Slide 1: Dos tarjetas -->
                        <div class="swiper-slide">
                            <div class="cards-container">
                                <!-- Tarjeta Uno -->
                                <div class="card">
                                    <figure>
                                        <img src="assets/img/carrusel/catering1.png">
                                    </figure>
                                    <div class="descripcion">
                                        <h3>Paquete Sencillo</h3>
                                        <p>Ideal para 50 invitados. <br>Incluye banquete a 3 tiempos, con comidas de su
                                            elección. <br>Cuenta con servicio de mantelería, cristalería.</p>
                                        <a href="" class="card_abierta" data-id="1">Leer más</a>
                                    </div>
                                </div>
                                <!-- Tarjeta Dos -->
                                <div class="card">
                                    <figure>
                                        <img src="assets/img/carrusel/catering2.png">
                                    </figure>
                                    <div class="descripcion">
                                        <h3>Paquete Fiesta</h3>
                                        <p>Ideal para 100 invitados. <br>Incluye banquete a 3 tiempos, con comidas de su
                                            elección. <br>Cuenta con servicio de mantelería, cristalería y meseros.</p>
                                        <a href="#" class="card_abierta" data-id="2">Leer más</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2: Dos tarjetas -->
                        <div class="swiper-slide">
                            <div class="cards-container">
                                <!-- Tarjeta Tres -->
                                <div class="card">
                                    <figure>
                                        <img src="assets/img/carrusel/catering3.png">
                                    </figure>
                                    <div class="descripcion">
                                        <h3>Paquete Evento</h3>
                                        <p>Ideal para 200 invitados. <br>Incluye banquete a 3 tiempos, con comidas de su
                                            elección. <br>Cuenta con servicio de mantelería, cristalería, meseros,
                                            música en vivo y decoración de evento.</p>
                                        <a href="#" class="card_abierta" data-id="3">Leer más</a>
                                    </div>
                                </div>
                                <!-- Tarjeta Cuatro -->
                                <div class="card">
                                    <figure>
                                        <img src="assets/img/carrusel/catering4.png">
                                    </figure>
                                    <div class="descripcion">
                                        <h3>Paquete Personalizado</h3>
                                        <p>Este paquete es completamente personalizable, usted decide que servicios
                                            requiere, que cantidad de invitados manejar, temática del evento y por
                                            supuesto, que alimentos consumir. </p>
                                        <a href="#" class="card_abierta" data-id="4">Leer más</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Más slides con dos tarjetas cada uno -->

                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>



    <!-- Modal card 1 -->
    <section class="modal">
        <div class="modal_container">
            <img src="assets/img/carrusel/catering1.png" class="modal_img">
            <h2 class="modal_tittle">paquete 1</h2>
            <p class="modal_paragraph">Descripción del paquete 1.</p>
            <div class="modal_buttons">
                <a href="#" class="modal_close">Cerrar</a>
                <a href="#" class="modal_formulario">Cotizar</a>
            </div>
        </div>
    </section>

    <!-- Modal card 2 -->
    <section class="modal">
        <div class="modal_container">
            <img src="assets/img/carrusel/catering2.png" class="modal_img">
            <h2 class="modal_tittle">paquete 2</h2>
            <p class="modal_paragraph">Descripción del paquete 2.</p>
            <div class="modal_buttons">
                <a href="#" class="modal_close">Cerrar</a>
                <a href="php/verificar_cotizacion.php?=paquete2" class="modal_formulario">Cotizar</a>
            </div>
        </div>
    </section>

    <!-- Modal card 3 -->
    <section class="modal">
        <div class="modal_container">
            <img src="assets/img/carrusel/catering3.png" class="modal_img">
            <h2 class="modal_tittle">paquete 3</h2>
            <p class="modal_paragraph">Descripción del paquete 3.</p>
            <div class="modal_buttons">
                <a href="#" class="modal_close">Cerrar</a>
                <a href="php/verificar_cotizacion.php?paquete=3" class="modal_formulario">Cotizar</a>
            </div>
        </div>
    </section>

    <!-- Modal card 4 -->
    <section class="modal">
        <div class="modal_container">
            <img src="assets/img/carrusel/catering4.png" class="modal_img">
            <h2 class="modal_tittle">paquete 4</h2>
            <p class="modal_paragraph">Descripción del paquete 4.</p>
            <div class="modal_buttons">
                <a href="#" class="modal_close">Cerrar</a>
                <a href="php/verificar_cotizacion.php?paquete=4" class="modal_formulario">Cotizar</a>
            </div>
        </div>
    </section>


    <!-- Portfolio-->
    <div id="portfolio">
        <div class="container-fluid p-0">
            <h2 class="text-center mt-0">Historial de Eventos</h2>
            <hr class="divider" />
            <div class="row g-0">
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="assets/img/portfolio/fullsize/1.jpg" title="BODA">
                        <img class="img-fluid" src="assets/img/portfolio/thumbnails/1.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Catering para Bodas</div>
                            <div class="project-name">Boda</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="assets/img/portfolio/fullsize/2.jpg" title="XV AÑOS">
                        <img class="img-fluid" src="assets/img/portfolio/thumbnails/2.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Catering para Eventos Temáticos</div>
                            <div class="project-name">XV Años</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="assets/img/portfolio/fullsize/3.jpg" title="EMPRESARIAL">
                        <img class="img-fluid" src="assets/img/portfolio/thumbnails/3.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Catering Empresarial</div>
                            <div class="project-name">Reunión Casa Blanca</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="assets/img/portfolio/fullsize/4.jpg" title="BUFFET">
                        <img class="img-fluid" src="assets/img/portfolio/thumbnails/4.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Buffet</div>
                            <div class="project-name">Evento Social</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="assets/img/portfolio/fullsize/5.jpg" title="COCTELERIA">
                        <img class="img-fluid" src="assets/img/portfolio/thumbnails/5.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Coctelería</div>
                            <div class="project-name">Barra libre</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="assets/img/portfolio/fullsize/6.png" title="SALUDABLE">
                        <img class="img-fluid" src="assets/img/portfolio/thumbnails/6.png" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Catering Saludable</div>
                            <div class="project-name">Eventos Sociales</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">Copyright &copy; 2025 - FOOD & MOOD</div>
        </div>
    </footer>
</body>

</html>