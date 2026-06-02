<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros – Suits</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <div class="main-content">
                <div class="pink-section">
                    <div class="image-container">
                        <img src="assets/img/tienda.jpg" alt="Nuestra empresa">
                    </div>
                    <div class="content">
                        <h4>BIENVENIDOS A SUITS</h4>
                        <h2>Nuestra Empresa</h2>
                        <p>En Suits, nos dedicamos a ofrecer las mejores prendas formales y accesorios para cualquier ocasión especial. Con años de experiencia en el sector, trabajamos con las marcas más prestigiosas para que nuestros clientes siempre luzcan elegantes.</p>
                    </div>
                </div>
            </div>

            <div class="brand-section">
                <h2 class="section-title">Nuestros Servicios</h2>
                <div class="brand-cards">
                    <div class="brand-card">
                        <div class="imagen-marca"><img src="assets/img/trajes.jpg" alt="Servicio 1"></div>
                        <div class="brand-info">
                            <h3>Alquiler y Venta de Trajes y Vestidos</h3>
                            <p>Ofrecemos una amplia gama de trajes y vestidos de alta calidad para alquiler, adaptados a tus necesidades.</p>
                        </div>
                    </div>
                    <div class="brand-card">
                        <div class="imagen-marca"><img src="assets/img/accesorios.jpg" alt="Servicio 2"></div>
                        <div class="brand-info">
                            <h3>Venta de Accesorios</h3>
                            <p>Encuentra los mejores accesorios para complementar tu traje o vestido.</p>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="main-content">
                <div class="pink-section">
                    <div class="image-container">
                        <img src="assets/img/mision_vision.jpeg" alt="Nuestra empresa">
                    </div>
                    <div class="content">
                        <h2>Nuestra Misión y Visión</h2>

                        <h4>Misión</h4>
                        <p>Ofrecer trajes y accesorios de alta calidad a precios justos, garantizando una experiencia de compra o alquiler fácil y satisfactoria para cualquier ocasión especial.</p>

                        <h4>Visión</h4>
                        <p>Ser una tienda de referencia en el sector, expandiéndonos con un enfoque en la excelente relación calidad-precio y un servicio al cliente excepcional.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
</body>

</html>
