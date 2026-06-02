<?php
session_start();

include_once "logica/persona.php";

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_POST['vaciar_carrito'])) {
    // Vaciar el carrito
    $_SESSION['carrito'] = [];
    header('Location: carrito.php');
    exit();
}

// Maneja la adición, actualización o eliminación de productos en el carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = $_POST['id_producto'] ?? null;
    $accion = $_POST['accion'] ?? null;  // Se añade la variable 'accion' para definir si se elimina un producto
    $cantidad = $_POST['cantidad'] ?? 1;

    $persona = new Persona();

    if ($id_producto && $accion === 'eliminar') {
        // Eliminar el producto del carrito
        unset($_SESSION['carrito'][$id_producto]);
        header('Location: carrito.php');
        exit();
    }

    // Validar que la cantidad sea un número válido mayor o igual a 1
    if ($id_producto && is_numeric($cantidad) && (int)$cantidad > 0) {
        $producto = $persona->obtenerProductoPorId($id_producto);

        if ($producto) {
            // Verificar la cantidad disponible
            $cantidad_disponible = $producto->getCantidad();

            if ($cantidad > $cantidad_disponible) {
                // Si la cantidad solicitada es mayor que la disponible, mostrar SweetAlert
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Advertencia',
                            text: 'No hay suficiente stock disponible para " . htmlspecialchars($producto->getNombre()) . ". Solo hay " . $cantidad_disponible . " disponible.',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    });
                </script>";
            } else {
                // Actualizar la cantidad del producto en el carrito
                $_SESSION['carrito'][$id_producto] = [
                    'nombre' => $producto->getNombre(),
                    'precio' => $producto->getPrecio(),
                    'imagen' => $producto->getImagenUrl(),
                    'cantidad' => (int)$cantidad
                ];
                header('Location: carrito.php');
                exit();
            }
        } else {
            echo "Producto no encontrado.";
            exit();
        }
    }

    if ($accion === 'comprar') {
        $total = 0;

        // Calcular el total y el subtotal para cada producto
        foreach ($_SESSION['carrito'] as $id_producto => $detalles) {
            $subtotal = $detalles['precio'] * $detalles['cantidad'];
            $total += $subtotal;
        }

        $_SESSION['total_compra'] = $total;

        header('Location: confirmar_compra.php');
        exit();
    }
}

$total = 0;
$carrito_vacio = empty($_SESSION['carrito']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito – Suits</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <style>
        /* Estilos generales */
        .contenedor-carrito {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .producto {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            position: relative;
            flex-wrap: wrap;
            /* Asegurarse de que el contenido se ajuste en pantallas pequeñas */
        }

        .producto-imagen {
            width: 80px;
            height: auto;
            object-fit: cover;
            margin-right: 15px;
        }

        .producto-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .eliminar-btn {
            background: none;
            border: none;
            color: #e74c3c;
            cursor: pointer;
            font-size: 1.5rem;
            position: absolute;
            right: 10px;
            top: 10px;
        }

        /* Mejora del input de cantidad */
        .form-group input {
            border: 1px solid var(--clr-main-light);
            border-radius: 2rem;
            font-size: 1.1rem;
            /* Aumentar el tamaño del input */
            padding: 5px;
            /* Más espacio interno */
            width: 50px;
            /* Aumentar el tamaño para que sea más fácil interactuar */
            text-align: center;
            margin-right: 10px;
        }

        /* Quitar flechas en inputs tipo number en navegadores WebKit */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Quitar flechas en inputs tipo number en Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
            /* Para Firefox */
            appearance: none;
            /* Propiedad estándar para todos los navegadores */
        }

        /* Responsive para pantallas pequeñas */
        @media (max-width: 600px) {
            .producto {
                flex-direction: column;
                /* Colocar elementos en columna */
                align-items: flex-start;
                /* Alinear a la izquierda */
            }

            .producto-imagen {
                width: 100px;
                /* Aumentar un poco el tamaño de la imagen en móvil */
                margin-bottom: 10px;
            }

            .eliminar-btn {
                font-size: 1.2rem;
                /* Reducir un poco el tamaño del ícono en pantallas pequeñas */
                top: 5px;
                right: 5px;
            }

            .form-group input {
                width: 60px;
                /* Aumentar el tamaño del input de cantidad */
                margin-top: 5px;
            }

            .carrito-acciones {
                flex-direction: column;
                /* Colocar los botones de acciones en columna */
                align-items: stretch;
            }

            .carrito-acciones-comprar,
            .carrito-acciones-vaciar {
                width: 100%;
                /* Asegurarse de que los botones ocupen el ancho completo */
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <h2 class="titulo-principal">Carrito</h2>
            <div class="contenedor-carrito">
                <?php if ($carrito_vacio): ?>
                    <p id="carrito-vacio" class="carrito-vacio">Tu carrito está vacío.</p>
                <?php else: ?>
                    <div id="carrito-productos" class="carrito-productos">
                        <?php foreach ($_SESSION['carrito'] as $id_producto => $detalles):
                            $subtotal = $detalles['precio'] * $detalles['cantidad'];
                            $total += $subtotal;
                        ?>
                            <div class="producto">
                                <a href="detalle_producto.php?id=<?php echo htmlspecialchars($id_producto); ?>">
                                    <img src="assets/img/productos/<?php echo htmlspecialchars($detalles['imagen']); ?>" alt="<?php echo htmlspecialchars($detalles['nombre']); ?>" class="producto-imagen">
                                </a>
                                <div class="producto-info">
                                    <a href="detalle_producto.php?id=<?php echo htmlspecialchars($id_producto); ?>" style="text-decoration: none; color: inherit;">
                                        <h3><?php echo htmlspecialchars($detalles['nombre']); ?></h3>
                                    </a>

                                    <!-- Selector de cantidad -->
                                    <form method="post" action="carrito.php" class="form-group">
                                        <label for="cantidad">Cantidad: </label>
                                        <input type="number" name="cantidad" id="cantidad" value="<?php echo $detalles['cantidad']; ?>" min="1" max="10">
                                        <!-- Campo oculto para pasar el ID del producto -->
                                        <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                    </form>

                                    <p>Precio Unitario: $<?php echo number_format($detalles['precio'], 0, ',', '.'); ?></p>
                                    <p>Subtotal: $<?php echo number_format($subtotal, 0, ',', '.'); ?></p>
                                </div>

                                <!-- Botón para eliminar producto -->
                                <form method="post" action="carrito.php">
                                    <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <button type="submit" class="eliminar-btn">
                                        <i class="mdi mdi-trash-can-outline" title="Quitar Producto"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div id="carrito-acciones" class="carrito-acciones">
                        <div class="carrito-acciones-izquierda">
                            <form method="post" action="">
                                <button type="submit" name="vaciar_carrito" id="carrito-acciones-vaciar" class="carrito-acciones-vaciar">Vaciar carrito</button>
                            </form>
                        </div>
                        <div class="carrito-acciones-derecha">
                            <div class="carrito-acciones-total">
                                <p>Total:</p>
                                <p id="total">$<?php echo number_format($total, 0, ',', '.'); ?></p>
                            </div>
                            <form method="post" action="carrito.php">
                                <input type="hidden" name="accion" value="comprar">
                                <button type="submit" id="carrito-acciones-comprar" class="carrito-acciones-comprar">Comprar ahora</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>

</html>