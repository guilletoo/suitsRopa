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

// Obtener la lista de administradores
$a = new Admin();
$administradores = $a->listarAdministradores();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Administradores – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link rel="stylesheet" href="assets/css/gestionar_productos.css">
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
            <h2 class="titulo-principal">Gestionar Administradores</h2>
            <div class="form-container">
                <h2 class="form-title">Agregar Administrador</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="cedula">Número de cédula</label>
                        <input type="number" id="cedula" name="cedula" autocomplete="off" required>
                    </div>
                    <button type="submit" class="admin-action-btn" name="agregar_admin">Agregar Admin</button>
                </form>
            </div>
            <br>

            <!-- Tabla de administradores -->
            <h2 class="form-title">Listado de Administradores</h2>
            <div class="table-container">
                <?php if (!empty($administradores)) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($administradores as $admin) : ?>
                                <tr>
                                    <td><?php echo $admin['cedula']; ?></td>
                                    <td><?php echo $admin['nombre']; ?></td>
                                    <td><?php echo $admin['apellido']; ?></td>
                                    <td class="actions">
                                        <!-- Botón para eliminar administrador -->
                                        <form action="" method="post" style="display:inline;">
                                            <input type="hidden" name="cedula" value="<?php echo $admin['cedula']; ?>">
                                            <button type="submit" class="action-btn" title="Eliminar Admin" name="eliminar_admin">
                                                <i class="mdi mdi-delete" style="color: red;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No hay administradores en este momento.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
</body>

</html>