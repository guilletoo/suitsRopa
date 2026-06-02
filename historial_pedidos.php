<?php
session_start();

// Verifica si la sesión está iniciada y si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['estado_admin'] ==  1) {
    header('Location: index.php'); // Redirige si no está autenticado o no es admin
    exit();
}

include_once 'persistencia/persona_bd.php';
include_once 'logica/producto.php';

// Obtener la cédula del usuario
$cedula_usuario = $_SESSION['usuario']['cedula'];

// Crear instancia de PersonaBD
$personaBD = new PersonaBD();
$compras = $personaBD->obtenerHistorialCompras($cedula_usuario);
$alquileres = $personaBD->obtenerHistorialAlquileres($cedula_usuario);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <style>
        /* Estilos nuevos */
        .invoice-card {
            width: 100%;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .invoice-header {
            background-color: #28a745;
            color: white;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .invoice-header .status {
            font-weight: bold;
        }

        .invoice-header .date {
            font-size: 0.9em;
            margin-right: 8px;
        }

        .invoice-header .download-icon {
            font-size: 24px;
            position: absolute;
            top: 16px;
            right: 16px;
            cursor: pointer;
        }

        .invoice-body {
            padding: 16px;
            background-color: #e9e9e9;
        }

        .product-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .product-item {
            display: flex;
            gap: 16px;
            align-items: center;
            background-color: white;
            padding: 8px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 20px;
        }

        .product-info {
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-weight: bold;
        }

        .product-quantity,
        .product-subtotal {
            font-size: 0.9em;
            color: #555;
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding: 10px;
            background-color: white;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1.2em;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .total-label {
            color: #333;
        }

        .total-amount {
            color: #28a745;
        }

        .action-btn.download {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .action-btn.download i {
            font-size: 30px;
            color: #fff;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .invoice-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .invoice-header .download-icon {
                position: absolute;
                top: 16px;
                right: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <div class="container">
                <h2 style="margin-bottom: 10px;">Historial de Compras</h2>
                <?php if (empty($compras)): ?>
                    <p>No has realizado ninguna compra aún.</p>
                <?php else: ?>
                    <?php foreach ($compras as $compra): ?>
                        <div class="invoice-card" style="margin-bottom: 10px;">
                            <div class="invoice-header">
                                <span class="status">Pedido Finalizado</span>
                                <span class="date">Fecha: <?php echo date("d/m/Y H:i", strtotime($compra['fecha_compra'])); ?></span>
                                <span class="date">Número de Pedido: <?php echo $compra['id_compra']; ?></span>
                                <button class="action-btn download" title="Descargar Factura" onclick="window.open('Factura_Compra.php?id_compra=<?php echo $compra['id_compra']; ?>&fecha_compra=<?php echo urlencode($compra['fecha_compra']); ?>', '_blank')">
                                    <i class="mdi mdi-download"></i>
                                </button>
                            </div>
                            <div class="invoice-body">
                                <div class="product-list">
                                    <?php
                                    $detalles = $personaBD->obtenerDetallesCompra($compra['id_compra']);
                                    foreach ($detalles as $detalle):
                                    ?>
                                        <div class="product-item">
                                            <div class="product-info">
                                                <p class="product-name"><?php echo htmlspecialchars($detalle['nombre_producto']); ?></p>
                                                <p class="product-quantity">Cantidad: <?php echo $detalle['cantidad']; ?></p>
                                                <p class="product-subtotal">Subtotal: $<?php echo number_format($detalle['subtotal'], 0, ',', '.'); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="total-section">
                                    <p class="total-label">Total de la compra:</p>
                                    <p class="total-amount">$<?php echo number_format($compra['total'], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <h2 style="margin-bottom: 10px;">Historial de Reservas</h2>
                <?php if (empty($alquileres)): ?>
                    <p>No has realizado ningún alquiler aún.</p>
                <?php else: ?>
                    <?php foreach ($alquileres as $alquiler): ?>
                        <div class="invoice-card" style="margin-bottom: 10px;">
                            <div class="invoice-header">
                                <span class="status">Pedido Finalizado</span>
                                <span class="date">Fecha de Retiro: <?php echo date("d/m/Y", strtotime($alquiler['fecha_retiro'])); ?></span>
                                <span class="date">Fecha de Devolución: <?php echo date("d/m/Y", strtotime($alquiler['fecha_devolucion'])); ?></span>
                                <span class="date">Número de Pedido: <?php echo htmlspecialchars($alquiler['id_alquiler']); ?></span>
                            </div>
                            <div class="invoice-body">
                                <?php
                                // Obtener detalles del producto relacionado con el alquiler
                                $producto = $personaBD->obtenerProductoPorId($alquiler['id_producto']);
                                $nombre_producto = $producto ? $producto->getNombre() : "Producto no encontrado";
                                ?>
                                <div class="product-list">
                                    <div class="product-item">
                                        <p class="product-name"><?php echo htmlspecialchars($nombre_producto); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
    <script src="assets/js/home.js"></script>
</body>

</html>