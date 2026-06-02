<?php
session_start();

// Verifica si la sesión está iniciada y si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['estado_admin'] == 1) {
    header('Location: login.php'); // Redirige si no está autenticado
    exit();
}

if (empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit();
}

// Recuperamos el total de la compra
$total_compra = $_SESSION['total_compra'] ?? 0;

// Recuperamos los detalles del carrito
$carrito = $_SESSION['carrito'];

$productos_resumen = '';

// Crear un resumen de los productos en el carrito
foreach ($carrito as $id_producto => $detalles) {
    $subtotal = $detalles['precio'] * $detalles['cantidad'];
    $productos_resumen .= "<strong>" . htmlspecialchars($detalles['nombre']) . "</strong><br>" .
        "Precio: $" . number_format($detalles['precio'], 0, ',', '.') . "<br>" .
        "Cantidad: " . $detalles['cantidad'] . "<br><br>";
}

include_once 'logica/persona.php';
include_once 'logica/compra.php';

$cedula_usuario = $_SESSION['usuario']['cedula'];

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

if (isset($_POST['confirmar_compra'])) {
    $forma_pago = $_POST['forma_pago'];

    // Validación si se selecciona tarjeta
    if ($forma_pago === 'tarjeta') {
        $numero_tarjeta = $_POST['numero_tarjeta'];
        $cvv_tarjeta = $_POST['cvv_tarjeta'];
        $mes_vencimiento = $_POST['mes_vencimiento'];
        $anio_vencimiento = $_POST['anio_vencimiento'];

        if (!is_numeric($numero_tarjeta)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El número de tarjeta debe contener solo números.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } elseif (empty($numero_tarjeta)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El número de tarjeta es obligatorio y debe completarse.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } elseif (!is_numeric($cvv_tarjeta)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El CVV debe contener solo números.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } elseif (empty($cvv_tarjeta)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El CVV es obligatorio y debe completarse.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } elseif (empty($mes_vencimiento)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Debes completar el mes de vencimiento.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } elseif (empty($anio_vencimiento)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Debes completar el año de vencimiento.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } else {
            $compra = new Compra($cedula_usuario, $carrito); // Crea la compra con todos los productos en el carrito
            if ($compra->comprar()) { // Si la compra se realiza correctamente
                // Vaciar el carrito después de la compra
                $_SESSION['carrito'] = [];
                $_SESSION['total_compra'] = 0; // También reinicia el total de compra
            } else {
                echo "<script>console.log('Error: Hubo un problema al procesar tu compra. Intenta nuevamente.');</script>";
            }
        }
    }

    // Validación si se selecciona efectivo
    elseif ($forma_pago === 'efectivo') {
        $cedula = $_POST['cedula'];

        if (!is_numeric($cedula)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La cédula debe contener solo números.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } elseif (empty($cedula)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La cédula es obligatoria y debe completarse.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        } else {
            // Procesar la compra si no hay errores
            $compra = new Compra($cedula_usuario, $carrito); // Crea la compra con todos los productos en el carrito
            if ($compra->comprar()) { // Si la compra se realiza correctamente
                // Vaciar el carrito después de la compra
                $_SESSION['carrito'] = [];
                $_SESSION['total_compra'] = 0; // También reinicia el total de compra
            } else {
                echo "<script>console.log('Error: Hubo un problema al procesar tu compra. Intenta nuevamente.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Compra – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/confirmar_compra.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <style>
        /* Estilo base para el botón radio */
        .radio-button {
            display: none;
            /* Ocultamos el radio original */
        }

        /* Estilo para el contenedor del label del radio */
        .label-radio {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 2px 8px;
            margin-bottom: 8px;
            font-size: 1rem;
            color: var(--clr-main);
            background-color: transparent;
            border: 2px solid var(--clr-main);
            border-radius: 2rem;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Efecto de hover */
        .label-radio:hover {
            background-color: var(--clr-main-light);
            color: var(--clr-white);
        }

        /* Estilo cuando el radio está seleccionado */
        .radio-button:checked+.label-radio {
            background-color: var(--clr-main);
            color: var(--clr-white);
            border-color: var(--clr-main);
        }

        /* Contenedor de opciones de pago alineado en fila */
        .label-container {
            display: inline;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .label-container label {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <h2 class="titulo-principal">Confirmación de compra</h2>

            <div class="container">
                <!-- Formulario de compra -->
                <section class="form-section">
                    <h2>Detalles de envío</h2>

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
                                <button type="submit" class="update-profile-btn" name="completar_datos">Actualizar Datos Personales</button>
                            </form>
                        </div>
                    </div>

                    <h2>Elige tu forma de pago</h2>
                    <div class="payment-container">
                        <form action="" method="post">
                            <div class="payment-option">
                                <!-- Opciones de pago -->
                                <div class="label-container">
                                    <input type="radio" id="pago_tarjeta" class="radio-button" name="forma_pago" value="tarjeta" required>
                                    <label for="pago_tarjeta" class="label-radio">
                                        <i class="mdi mdi-credit-card" style="font-size: 2rem;"></i> Tarjeta de débito o crédito
                                    </label>

                                    <input type="radio" id="pago_efectivo" class="radio-button" name="forma_pago" value="efectivo" required>
                                    <label for="pago_efectivo" class="label-radio">
                                        <i class="mdi mdi-cash-multiple" style="font-size: 2rem;"></i> Efectivo en red de cobranza
                                    </label>
                                </div>

                                <!-- Formulario de tarjeta de crédito/débito -->
                                <div id="form-tarjeta" class="form-content">
                                    <div class="form-group">
                                        <label for="numero_tarjeta">Número de tarjeta</label>
                                        <input type="text" id="numero_tarjeta" name="numero_tarjeta" maxlength="16" minlength="16" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="nombre_tarjeta">Nombre del titular</label>
                                        <input type="text" style="text-transform: uppercase;" id="nombre_tarjeta" name="nombre_tarjeta" maxlength="16" autocomplete="off">
                                    </div>

                                    <div class="form-group">

                                        <label for="vencimiento_tarjeta">Vencimiento</label>
                                        <div style="display: flex; gap: 10px;">
                                            <select id="mes_vencimiento" name="mes_vencimiento">
                                                <option value="" disabled selected>Mes</option>
                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                    <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>">
                                                        <?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                            <select id="anio_vencimiento" name="anio_vencimiento">
                                                <option value="" disabled selected>Año</option>
                                                <?php for ($i = date('y'); $i <= date('y') + 5; $i++): ?>
                                                    <option value="<?php echo $i; ?>">
                                                        <?php echo $i; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cvv_tarjeta">Código de seguridad</label>
                                        <input type="text" id="cvv_tarjeta" name="cvv_tarjeta" maxlength="3" minlength="3" autocomplete="off">
                                    </div>
                                </div>

                                <!-- Formulario de pago en efectivo -->
                                <div id="form-efectivo" class="form-content">
                                    <div class="form-group">
                                        <label for="cedula">Cédula de Identidad</label>
                                        <input type="number" id="cedula" name="cedula" maxlength="8" minlength="1" autocomplete="off">
                                    </div>
                                    <p style="margin-top: 10px;">Se aceptan pagos en Abitab y RedPagos.</p>
                                </div>
                            </div>
                            <!-- Botón para confirmar y pagar -->
                            <div class="pagar">
                                <button type="submit" class="pagar-button" name="confirmar_compra">Pagar</button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Resumen de compra -->
                <aside class="summary">
                    <h3>Resumen de compra</h3>
                    <hr>
                    <p><br><?php echo $productos_resumen; ?></p>
                    <p>Envío <span class="free">Gratis</span></p>
                    <hr>
                    <p style="font-size: 1.2rem; color: black;">Total <strong style="float: right">$<?php echo number_format($total_compra, 0, ',', '.'); ?></strong></p>
                </aside>

                <!-- Resumen de compra para móviles -->
                <div class="summary-total-mobile">
                    <p>Total <span class="total-price">$<?php echo number_format($total_compra, 0, ',', '.'); ?></span></p>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Seleccionar radios y formularios
        const radioTarjeta = document.getElementById('pago_tarjeta');
        const radioEfectivo = document.getElementById('pago_efectivo');
        const formTarjeta = document.getElementById('form-tarjeta');
        const formEfectivo = document.getElementById('form-efectivo');

        // Función para mostrar el formulario según la selección
        function mostrarFormulario() {
            formTarjeta.style.display = radioTarjeta.checked ? 'block' : 'none';
            formEfectivo.style.display = radioEfectivo.checked ? 'block' : 'none';

            // Configurar atributos "required" solo para los campos visibles
            document.querySelectorAll('#form-tarjeta input').forEach(input => {
                input.required = radioTarjeta.checked;
            });
            document.querySelectorAll('#form-efectivo input').forEach(input => {
                input.required = radioEfectivo.checked;
            });
        }

        // Escuchar cambios en los radios
        radioTarjeta.addEventListener('change', mostrarFormulario);
        radioEfectivo.addEventListener('change', mostrarFormulario);

        // Mostrar el formulario inicial según el valor seleccionado al cargar
        mostrarFormulario();
    </script>

    <script src="assets/js/home.js"></script>
</body>

</html>