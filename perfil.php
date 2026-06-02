<?php
session_start();

// Verifica si la sesión está iniciada
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php'); // Redirige si no está autenticado
    exit();
}

include_once 'logica/persona.php';

$cedula_usuario = $_SESSION['usuario']['cedula'];

if (isset($_POST['editar_perfil'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $fecha_nacimiento = strtotime($_POST['fecha_nacimiento']);
    $fecha_actual = strtotime(date("d-m-Y", time()));

    // Verificar que el teléfono sea numérico o esté vacío
    if (empty($telefono)) {
        $telefono = ''; // Si está vacío, asignamos una cadena vacía
    } elseif (!is_numeric($telefono)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El teléfono debe contener solo números.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        $telefono = ''; // Asignamos una cadena vacía en caso de advertencia
    } elseif (strlen($telefono) > 15) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El teléfono debe tener un máximo de 15 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    }
    // Verificar longitud de nombre y apellido
    elseif (strlen($nombre) > 30 || strlen($apellido) > 30) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El nombre y el apellido debe tener un máximo de 30 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($fecha_actual < $fecha_nacimiento) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La fecha de nacimiento debe ser anterior a la fecha actual.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($direccion) > 50) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La dirección debe tener un máximo de 50 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($email) > 50) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El email debe tener un máximo de 50 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($nombre) >= 30 || strlen($apellido) >= 30) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El nombre y el apellido deben tener un máximo de 30 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($nombre) < 1 || strlen($apellido) < 1) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El nombre y el apellido deben tener al menos 1 carácter.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } else {
        // Guardar perfil si todas las validaciones pasan
        $a = new Persona();
        $a->setCedula($cedula_usuario);
        $a->setNombre($nombre);
        $a->setApellido($apellido);
        $a->setEmail($email);
        $a->setTelefono($telefono);
        $a->setDireccion($direccion);
        $a->setFechaNacimiento($_POST['fecha_nacimiento']);
        $a->editarPerfil();
    }
}

if (isset($_POST['cambiar_contrasena'])) {
    $contrasena_actual = $_POST['contrasena_actual'];
    $contrasena_nueva = $_POST['contrasena_nueva'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verificar que la nueva contraseña tenga al menos 8 caracteres
    if (strlen($contrasena_nueva) < 12) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La nueva contraseña debe tener al menos 12 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($contrasena_nueva) > 50) {
        // Verificar que las contraseñas nuevas coincidan
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La nueva contraseña debe tener menos de 50 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($contrasena_nueva !== $confirmar_contrasena) {
        // Verificar que las contraseñas nuevas coincidan
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Las contraseñas nuevas no coinciden.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } else {
        // Cambiar la contraseña si todo está correcto
        $a = new Persona();
        $a->setCedula($cedula_usuario);
        $a->cambiarContrasena($contrasena_actual, $contrasena_nueva);
    }
}

if (isset($_POST['dar_baja'])) {
    $a = new Persona();
    $a->setCedula($cedula_usuario);
    $a->darseDeBaja($_POST['baja_contrasena']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <style>
        /* Estilos originales */
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--clr-white);
            border-radius: 1rem;
        }

        .form-title,
        .form-subtitle {
            color: var(--clr-main);
            text-align: center;
        }

        .form-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .form-subtitle {
            color: var(--clr-red);
            font-size: 1.5rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
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

        .update-profile-btn,
        .delete-account-btn {
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
            gap: 13px;
        }

        .update-profile-btn {
            background-color: var(--clr-main);
        }

        .update-profile-btn:hover {
            background-color: var(--clr-main-light);
        }

        .delete-account-btn {
            background-color: var(--clr-red);
        }

        .delete-account-btn:hover {
            background-color: #a00d0d;
        }

        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal.show {
            display: flex;
        }

        /* Contenido del modal */
        .modal-content {
            background-color: var(--clr-white);
            color: var(--clr-main-dark);
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            max-height: 80%;
            /* Altura máxima del modal */
            overflow-y: auto;
            /* Habilita el desplazamiento vertical */
            border-radius: 1rem;
            opacity: 0;
            /* Inicialmente invisible */
            transform: translateY(-20px);
            /* Desplazamiento inicial */
            transition: opacity 0.3s ease, transform 0.3s ease;
            /* Transiciones suaves */
        }

        /* Clase para mostrar el modal */
        .modal.show .modal-content {
            opacity: 1;
            /* Al abrir, se vuelve visible */
            transform: translateY(0);
            /* Regresa a su posición original */
        }

        /* Botón cerrar */
        .close {
            color: #020000;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: var(--clr-red);
            text-decoration: none;
            cursor: pointer;
        }

        /* Media query para pantallas pequeñas */
        @media (max-width: 600px) {
            .modal-content {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <main>
            <h2 class="titulo-principal">Gestión de Perfil</h2>

            <!-- Botones para abrir los modales -->
            <div class="form-container">
                <button onclick="abrirModal('modalEditarPerfil')" class="update-profile-btn"><span class="mdi mdi-account-edit-outline" style="font-size:1rem" span> Editar Perfil</span></button>
            </div>

            <div class="form-container">
                <button onclick="abrirModal('modalCambiarContrasena')" class="delete-account-btn"><span class="mdi mdi-shield-edit-outline" style="font-size:1rem" span> Cambiar Contraseña </span></button>
            </div>

            <div class="form-container">
                <button onclick="abrirModal('modalDarBaja')" class="delete-account-btn"><span class="mdi mdi-delete" style="font-size:1rem" span> Desactivar Cuenta</span></button>
            </div>

            <!-- Verifica si no es administrador para mostrar el historial de pedidos -->
            <?php if ($_SESSION['usuario']['estado_admin'] != 1): ?>
                <div class="form-container">
                    <button onclick="window.location.href='historial_pedidos.php'" class="update-profile-btn"><span class="mdi mdi-basket-check" style="font-size:1rem" span> Historial de Pedidos</button>
                </div>
            <?php endif; ?>

            <!-- Modal para Editar Perfil -->
            <div id="modalEditarPerfil" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal('modalEditarPerfil')">
                        <i class="mdi mdi-close"></i>
                    </span>
                    <h2 class="form-title">Editar Perfil</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="cedula">Cédula</label>
                            <input type="text" id="cedula" name="cedula" disabled value="<?php echo $_SESSION['usuario']['cedula']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" autocomplete="off" required value="<?php echo $_SESSION['usuario']['nombre']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" autocomplete="off" required value="<?php echo $_SESSION['usuario']['apellido']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" autocomplete="off" required value="<?php echo $_SESSION['usuario']['email']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="number" id="telefono" name="telefono" maxlength="9" required autocomplete="off" value="<?php echo $_SESSION['usuario']['telefono']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" autocomplete="off" required value="<?php echo $_SESSION['usuario']['direccion']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required autocomplete="off" value="<?php echo $_SESSION['usuario']['fecha_nacimiento']; ?>">
                        </div>
                        <button type="submit" class="update-profile-btn" name="editar_perfil">Actualizar Perfil</button>
                    </form>
                </div>
            </div>

            <!-- Modal para Cambiar Contraseña -->
            <div id="modalCambiarContrasena" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal('modalCambiarContrasena')">
                        <i class="mdi mdi-close"></i>
                    </span>
                    <h3 class="form-subtitle">Cambiar Contraseña</h3>
                    <form method="post">
                        <div class="form-group">
                            <label for="contrasena_actual">Contraseña actual</label>
                            <input type="password" id="contrasena_actual" name="contrasena_actual" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena_nueva">Nueva contraseña</label>
                            <input type="password" id="contrasena_nueva" name="contrasena_nueva" autocomplete="off" minlength="8" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmar_contrasena">Confirmar contraseña</label>
                            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" autocomplete="off" minlength="8" required>
                        </div>
                        <button type="submit" class="delete-account-btn" name="cambiar_contrasena">Cambiar contraseña</button>
                    </form>
                </div>
            </div>

            <!-- Modal para Desactivar Cuenta -->
            <div id="modalDarBaja" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModal('modalDarBaja')">
                        <i class="mdi mdi-close"></i>
                    </span>
                    <h3 class="form-subtitle">Desactivar Cuenta</h3>
                    <form method="post">
                        <div class="form-group">
                            <label for="contrasena">Confirmar contraseña</label>
                            <input type="password" id="contrasena" name="contrasena" autocomplete="off" required>
                        </div>
                        <button type="submit" class="delete-account-btn" name="dar_baja">Desactivar cuenta</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
    <script>
        function abrirModal(id) {
            const modal = document.getElementById(id);
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('show'); // Agrega clase 'show' para iniciar la animación
            }, 10); // Pequeño retraso para permitir que el display sea 'flex'
        }

        function cerrarModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('show'); // Quita clase "show"
            setTimeout(() => {
                modal.style.display = 'none'; // Cambia a display: none después de la animación
            }, 300);
        }
    </script>
</body>

</html>