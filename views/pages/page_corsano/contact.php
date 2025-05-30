<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chiropractic - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/animate.css">

    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/magnific-popup.css">

    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/jquery.timepicker.css">

    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/flaticon.css">
    <link rel="stylesheet" href="<?= BASE ?>views/dist/pagina_web_corsano/css/style.css">
</head>

<body>
    <div class="top py-1">
        <div class="container">
            <div class="row">
                <div class="col d-flex align-items-center">
                    <p class="mb-0"><a href="#">chiropractic@email.com</a> | <a href="#">Help Desk</a> | </p>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <div class="social-media">
                        <p class="mb-0 d-flex">
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
                            <a href="#" class="d-flex align-items-center justify-content-center"><span
                                    class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="order-lg-last">
                <a href="#" class="btn btn-primary">Make an appointment</a>
            </div>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"><a class="nav-link">CORSANO</a></li>
                    <li class="nav-item"><a href="<?= BASE ?>index" class="nav-link">INICIO</a></li>
                    <li class="nav-item"><a href="<?= BASE ?>about" class="nav-link">NOSOTROS</a></li>
                    <li class="nav-item"><a href="<?= BASE ?>services" class="nav-link">SERVICIOS</a></li>
                    <!--           <li class="nav-item"><a href="<?= BASE ?>gallery" class="nav-link">GALERIA</a></li>
                    <li class="nav-item"><a href="<?= BASE ?>blog" class="nav-link">BLOG</a></li> -->
                    <li class="nav-item"><a href="<?= BASE ?>contact" class="nav-link">CONTACTOS</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
    <section class="hero-wrap hero-wrap-2"
        style="background-image: url('<?= BASE ?>views/dist/pagina_web_corsano/images/bg_2.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-end">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index">Inicio <i
                                    class="fa fa-chevron-right"></i></a></span> <span>Contactanos <i
                                class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Contactanos</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d498.35018643522193!2d-80.9248518761544!3d-2.228249287784385!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMsKwMTMnNDEuOSJTIDgwwrA1NScyOC44Ilc!5e0!3m2!1ses-419!2sec!4v1710099789286!5m2!1ses-419!2sec"
                        width="100%" height="350px" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-md-12">
                    <div class="wrapper">
                        <div class="row no-gutters">
                            <div class="col-md-7 d-flex">
                                <div class="contact-wrap w-100 p-md-5 p-4">
                                    <h3 class="mb-4">Get in touch</h3>
                                    <form method="POST" id="contactForm" class="contactForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="subject" id="subject"
                                                        placeholder="Subject">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <textarea name="message" class="form-control" id="message" cols="30"
                                                        rows="7" placeholder="Message"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" value="Send Message" class="btn btn-primary">
                                                    <div class="submitting"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-items-stretch">
                                <div class="info-wrap bg-primary w-100 p-lg-5 p-4">
                                    <h3 class="mb-4 mt-md-4">Contact us</h3>
                                    <div class="dbox w-100 d-flex align-items-start">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-map-marker"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016
                                            </p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-phone"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-paper-plane"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Email:</span> <a
                                                    href="mailto:info@yoursite.com">info@yoursite.com</a></p>
                                        </div>
                                    </div>
                                    <div class="dbox w-100 d-flex align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-globe"></span>
                                        </div>
                                        <div class="text pl-3">
                                            <p><span>Website</span> <a href="#">yoursite.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer ftco-section ftco-no-pt">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6 col-lg">
                    <div class="ftco-footer-widget py-4 py-md-5">
                        <h2 class="logo"><a href="#">Corsano CC</a></h2>
                        <p>Bienvenidos a nuestro Centro Cardiologico Corsano</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-4">
                            <li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg">
                    <div class="ftco-footer-widget ml-md-5 py-5">
                        <h2 class="ftco-heading-2">Servicios</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-1 d-block"><span
                                        class="fa fa-check mr-3"></span>Electrocardiogramas</a></li>
                            <li><a href="#" class="py-1 d-block"><span
                                        class="fa fa-check mr-3"></span>Ecocardiogramas</a></li>
                            <li><a href="#" class="py-1 d-block"><span class="fa fa-check mr-3"></span>Mapa</a></li>
                            <li><a href="#" class="py-1 d-block"><span class="fa fa-check mr-3"></span>Holter PA</a>
                            </li>
                            <li><a href="#" class="py-1 d-block"><span class="fa fa-check mr-3"></span>Holter EKG</a>
                            </li>
                            <li><a href="#" class="py-1 d-block"><span class="fa fa-check mr-3"></span>Consultas
                                    Medicas</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg">
                    <div class="ftco-footer-widget py-4 py-md-5">
                        <h2 class="ftco-heading-2">Informacion de Contacto</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon fa fa-map-marker"></span><span class="text">SALINAS, AV CARLOS
                                        ESPINOZA LARREA Y CALLE 5 FRENTE AL CENTRO DE ATENCION CIUDADANA </span></li>
                                <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+593
                                            997358073</span></a></li>
                                <li><a href="#"><span class="icon fa fa-paper-plane"></span><span
                                            class="text">corsano@gmail.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg">
                    <div class="ftco-footer-widget bg-primary p-4 py-5">
                        <h2 class="ftco-heading-2">Nuestros Horarios</h2>
                        <div class="opening-hours">
                            <h4>Dias:</h4>
                            <p class="pl-3">
                                <span>Lunes – Viernes : 3 pm a 8 pm</span>
                                <span>Sabado : 9 am a 5 pm</span>
                            </p>
                            <h4>Feriados:</h4>
                            <p class="pl-3">
                                <span>Todos los domingos</span> <br>
                                <span>Todos los Feriados</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                        </script> Todos los derechos reservados <i class="fa fa-heart" aria-hidden="true"></i>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </footer>



    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00" />
        </svg></div>


    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/popper.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/bootstrap.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery.easing.1.3.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery.waypoints.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery.stellar.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery.animateNumber.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/bootstrap-datepicker.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery.timepicker.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/owl.carousel.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/jquery.magnific-popup.min.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false">
    </script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/google-map.js"></script>
    <script src="<?= BASE ?>views/dist/pagina_web_corsano/js/main.js"></script>

</body>

</html>