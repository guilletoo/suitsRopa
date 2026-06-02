<?php
session_start();

// Verifica si la sesión está iniciada y si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['estado_admin'] != 1) {
    header('Location: index.php'); // Redirige si no está autenticado o no es admin
    exit();
}

include_once 'logica/persona.php';
include_once 'logica/admin.php';

if (isset($_POST['agregar_admin'])) {
    $a = new Admin();
    $a->setCedula($_POST['cedula']);
    $admin = $a->agregarAdmin();
}

if (isset($_POST['eliminar_admin'])) {
    $cedula = $_POST['cedula'];

    // Verifica si el admin que intenta eliminarse a sí mismo
    if ($cedula == $_SESSION['usuario']['cedula']) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'No puedes eliminarte a ti mismo.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } else {
        $a = new Admin();
        $a->setCedula($cedula);
        $admin = $a->eliminarAdmin();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administración – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Estilos adicionales específicos para el panel de administración */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--clr-white);
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            color: var(--clr-main);
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--clr-main);
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--clr-main-light);
            border-radius: 2rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--clr-main);
            box-shadow: 0 0 0 2px rgba(66, 69, 83, 0.527);
        }

        .admin-action-btn {
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

        .admin-action-btn:hover {
            background-color: var(--clr-main-light);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <h2 class="titulo-principal">Panel de Administración</h2>
            <div class="form-container">
                <h2 class="form-title">Gestionar Productos</h2>
                <a href="gestionar_productos.php">
                    <button class="admin-action-btn" name="gestionar_productos">Ir a Productos</button>
                </a>
            </div>
            <div class="form-container">
                <h2 class="form-title">Gestionar Pedidos</h2>
                <a href="gestionar_pedidos.php">
                    <button class="admin-action-btn" name="gestionar_pedidos">Ir a Pedidos</button>
                </a>
            </div>
            <div class="form-container">
                <h2 class="form-title">Gestionar Administradores</h2>
                <a href="gestionar_admin.php">
                    <button class="admin-action-btn" name="gestionar_admin">Ir a Administradores</button>
                </a>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
</body>

</html>