<?php
session_start();

if (isset($_POST["enviar"])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Enviado con éxito!',
                text: 'Tu mensaje ha sido enviado correctamente. Nos pondremos en contacto contigo pronto.',
                customClass: {
                    confirmButton: 'swal2-confirm'
                }
            });
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto – Suits</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <style>
        /* Agrupación de elementos del formulario */
        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Etiquetas de los inputs */
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--clr-main);
            font-weight: bold;
        }

        /* Estilo para los inputs de texto y número */
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="email"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--clr-main-light);
            border-radius: 2rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background-color: #fff;
            color: var(--clr-main-dark);
        }

        /* Enfoque para inputs, select y textarea */
        .form-group input[type="text"]:focus,
        .form-group input[type="number"]:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--clr-main);
            box-shadow: 0 0 0 2px rgba(66, 69, 83, 0.527);
        }

        /* Estilo para el textarea */
        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        /* Botón de actualización del perfil */
        .update-profile-btn {
            background-color: var(--clr-main);
            color: var(--clr-white);
            border: none;
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            width: 100%;
            margin-top: 1rem;
        }

        .update-profile-btn:hover {
            background-color: var(--clr-main-light);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <div class="container-contacto">
                <div class="detalles-empresa">
                    <h1>Nuestra Empresa</h1><span></span>
                    <div class="responsive-iframe">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3331.6327925182286!2d-56.52958932426251!3d-33.38065157341712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95a6eb5715adb18b%3A0x29174db632f7e588!2sGlamour%20-%20Alquiler%20de%20prendas%20finas!5e0!3m2!1ses!2suy!4v1730893413933!5m2!1ses!2suy" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <p><i class="mdi mdi-map-marker"></i> Herrera 664, Durazno, Uruguay</p>
                    <p><i class="mdi mdi-clock-outline"></i> Lunes a Viernes: 09:00 a 18:30 hs</p>
                    <p><i class="mdi mdi-clock-outline"></i> Sábado, 09:00 a 17:00 hs</p>
                    <p><i class="mdi mdi-phone"></i> <a href="tel:+59843623475">+598 4362 3475</a></p>
                    <p><i class="mdi mdi-phone"></i> <a href="tel:+59898274486">+598 98274486</a></p>
                </div>

                <div class="detalles-contacto">
                    <h1>Contactanos Aquí</h1>
                    <div class="form-contacto">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" id="apellido" name="apellido" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="mensaje">Mensaje</label>
                                <textarea name="mensaje" id="mensaje" cols="80" rows="10" required></textarea>
                            </div>
                            <button type="submit" class="update-profile-btn" name="enviar">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
</body>

</html>
