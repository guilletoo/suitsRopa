<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#404252">
    <title>Suits</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <?php if (isset($_SESSION['usuario'])) { ?>
                <!-- Opciones del menú para usuarios con sesión iniciada -->
                <div class="main-content">
                    <div class="pink-section">
                        <div class="image-container">
                            <img src="assets/img/grupo_mujeres.png" alt="Grupo de personas">
                        </div>
                        <div class="content">
                            <h4>COMIENZA AHORA </h4>
                            <h2>Bienvenido a Suits</h2>
                            <p>¿Quieres adquirir trajes sin restricciones en nuestro sitio? ¿Necesitas alquilar un vestido para el fin de semana? ¿Estás en busca de las prendas más elegantes para tu próximo evento?</p>
                            <button class="cta-button" onclick="location.href='empresa.php'">REALIZA TU PRIMER COMPRA</button>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Opción para iniciar sesión si no está autenticado -->
                <div class="main-content">
                    <div class="pink-section">
                        <div class="image-container">
                            <img src="assets/img/grupo_mujeres.png" alt="Grupo de personas">
                        </div>
                        <div class="content">
                            <h4>COMIENZA AHORA</h4>
                            <h2>Regístrate para explorar</h2>
                            <p>¿Quieres adquirir trajes sin restricciones en nuestro sitio? ¿Necesitas alquilar un vestido para el fin de semana? ¿Estás en busca de las prendas más elegantes para tu próximo evento?</p>
                            <button class="cta-button" onclick="location.href='login.php'">REGÍSTRATE YA</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="brand-section">
                <h2 class="section-title">Marcas con las que trabajamos</h2>
                <div class="brand-cards">
                    <div class="brand-card">
                        <div class="imagen-marca"><img src="assets/img/hugo_boss.jpeg" alt="Hugo Boss"></div>
                        <div class="brand-info">
                            <h3>HUGO BOSS</h3>
                            <p>Hugo Boss es una de las marcas de diseño en trajes y vestidos más importantes del mundo, reconocida por su vestimenta de alto nivel y cálidad.</p>
                        </div>
                    </div>

                    <div class="brand-card">
                        <div class="imagen-marca"><img src="assets/img/glamour.png" alt="Prada"></div>
                        <div class="brand-info">
                            <h3>GLAMOUR</h3>
                            <p>Alquiler de vestidos para fiesta, quince y novias, zapatos, carteras, bijou, abrigos, trajes, smokings, accesorios, para damas, caballeros y niños. Todo en fiesta.</p>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="brand-section-1">
                <h2 class="section-title-1">Sobre Nosotros</h2>
                <div class="brand-cards-1">
                    <div class="brand-card-1">
                        <a href="empresa.php">
                            <div class="brand-info-1">
                                <h3>Nuestra Empresa</h3>
                            </div>
                        </a>
                    </div>
                    <div class="brand-card-1">
                        <a href="contacto.php">
                            <div class="brand-info-1">
                                <h3>Contacto</h3>
                            </div>
                        </a>
                    </div>
                    <div class="brand-card-1">
                        <a href="preguntas_frecuentes.php">
                            <div class="brand-info-1">
                                <h3>Preguntas Frecuentes</h3>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/home.js"></script>
</body>

</html>