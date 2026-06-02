<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <div class="container">
                <div class="error-content">
                    <h1>Error 404</h1>
                    <h2>Producto no encontrado</h2>
                    <p>Lo sentimos, no pudimos encontrar el producto que buscas.</p>
                    <a href="index.php" class="button">Volver a Inicio</a>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
</body>

</html>