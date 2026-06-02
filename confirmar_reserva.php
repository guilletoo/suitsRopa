<?php
session_start();

include_once 'logica/reserva.php';
include_once 'logica/persona.php';
include_once 'persistencia/persona_bd.php';

// Verifica si la sesión está iniciada y si el usuario no es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['estado_admin'] == 1) {
    header('Location: login.php');
    exit();
}

// Verifica si se ha seleccionado un producto
if (!isset($_GET['id_producto'])) {
    header('Location: index.php');
    exit();
}

$id_producto = $_GET['id_producto'];
$cedula_usuario = $_SESSION['usuario']['cedula'];

$admin = new Persona();
$producto = $admin->obtenerProductoPorId($id_producto);

if ($producto) {
    $nombre_producto = $producto->getNombre();
    $precio_producto = $producto->getPrecio();
} else {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'Producto no encontrado.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    exit();
}

if (isset($_POST['completar_datos'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];

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
        $a->completarDatosPersonales();
    }
}

if (isset($_POST['confirmar_reserva'])) {
    $fecha_retiro = $_POST['fecha_retiro'];
    $fecha_devolucion = $_POST['fecha_devolucion'];

    // Obtener la fecha actual en formato 'Y-m-d' para comparar
    $fecha_actual = date('Y-m-d');
    $fecha_limite = '2025-01-31'; // Límite máximo permitido para reservar

    if (empty($fecha_retiro) || empty($fecha_devolucion)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor, seleccione ambas fechas.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($fecha_retiro < $fecha_actual) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La fecha de retiro no puede ser anterior a la fecha actual.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($fecha_devolucion <= $fecha_retiro) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La fecha de devolución debe ser posterior a la fecha de retiro.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($fecha_retiro > $fecha_limite || $fecha_devolucion > $fecha_limite) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: 'La agenda de reservas está disponible hasta el 31 de enero de 2025.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } else {
        // La validación fue exitosa, proceder con la reserva
        $reserva = new Reserva($fecha_retiro, $fecha_devolucion);
        $reserva->setCedula($cedula_usuario);
        $reserva->setIdProducto($id_producto);

        if ($reserva->reservar()) {
            echo "<script>console.log('Reserva confirmada con éxito.');</script>";
        } else {
            echo "<script>console.log('Hubo un problema al confirmar la reserva.');</script>";
        }
    }
}

// Para mostrar el nombre y precio en el resumen de reserva
$personaBD = new PersonaBD();
$producto = $personaBD->obtenerProductoPorId($id_producto);

// Asegúrate de verificar si el producto existe
$nombre_producto = $producto ? $producto->getNombre() : 'Producto no encontrado';
$precio_producto = $producto ? $producto->getPrecio() : 0; // Asume 0 si no se encuentra el producto
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Reserva – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/confirmar_compra.css">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>
        <main>
            <h2 class="titulo-principal">Confirmación de Reserva</h2>
            <div class="container">
                <section class="form-section">
                    <h2>Detalles de reserva</h2>
                    <div class="card-form">
                        <div class="card-info">
                            <form action="" method="post">
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
                                <button type="submit" class="update-profile-btn" name="completar_datos">Completar Datos</button>
                            </form>
                        </div>
                    </div>

                    <h2>Fecha de la reserva</h2>
                    <div class="payment-container">
                        <form action="" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($id_producto); ?>">
                            <div class="payment-option">
                                <div class="form-group">
                                    <label for="fecha_retiro">Fecha de Retiro</label>
                                    <input type="date" id="fecha_retiro" name="fecha_retiro" required onchange="calcularTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_devolucion">Fecha de Devolución</label>
                                    <input type="date" id="fecha_devolucion" name="fecha_devolucion" required onchange="calcularTotal()">
                                </div>
                                <button type="submit" class="update-profile-btn" name="confirmar_reserva">Confirmar Reserva</button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Resumen de reserva -->
                <aside class="summary">
                    <h3>Resumen de reserva</h3>
                    <hr style="margin-bottom: 10px;">
                    <div style="align-items: center;">
                        <p style="font-weight: bold; margin: 0;"><?php echo htmlspecialchars($nombre_producto); ?></p>
                        <p style="margin: 0;">$<?php echo number_format($precio_producto, 0, ',', '.'); ?> por día</p>
                    </div>
                    <hr style="margin-top: 10px;">
                    <p style="font-size: 1.2rem; color: black;">Total <strong style="float: right;">$ <span id="total_reserva">0</span></strong></p>
                </aside>

                <!-- Resumen de reserva para móviles -->
                <div class="summary-total-mobile">
                    <p>Total <span class="total-price">$<span id="total_reserva_mobile">0</span></span></p>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
    <script>
        function calcularTotal() {
            const fechaRetiro = document.getElementById('fecha_retiro').value;
            const fechaDevolucion = document.getElementById('fecha_devolucion').value;

            if (fechaRetiro && fechaDevolucion) {
                const fecha1 = new Date(fechaRetiro);
                const fecha2 = new Date(fechaDevolucion);

                if (fecha1 < fecha2) {
                    const diferenciaEnDias = (fecha2 - fecha1) / (1000 * 60 * 60 * 24);
                    const precioProducto = <?php echo $precio_producto; ?>;
                    const total = diferenciaEnDias * precioProducto;

                    // Formatear el total sin decimales, con puntos como separador de miles
                    const totalFormateado = total.toLocaleString('es-UY', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });

                    document.getElementById('total_reserva').textContent = totalFormateado;
                    document.getElementById('total_reserva_mobile').textContent = totalFormateado;
                }
            }
        }
    </script>
</body>

</html>