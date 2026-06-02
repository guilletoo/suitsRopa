<?php
session_start();
include_once "logica/admin.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vestidos – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <div class="buscador">
                <form action="" method="post" style="display: flex; width: 100%;">
                    <input type="search" name="buscar" autocomplete="off" placeholder="Buscar vestidos...">
                    <button type="submit"><span class="mdi mdi-magnify"></span></button>
                </form>
            </div>

            <div id="contenedor-productos" class="contenedor-productos">
                <?php
                $admin = new Admin();
                $listaProductos = $admin->listarProductoActivo();
                $busqueda = isset($_POST['buscar']) ? trim($_POST['buscar']) : '';

                // Verificar si la lista de productos es null
                if ($listaProductos != null && count($listaProductos) > 0) {
                    // Filtrar productos por búsqueda
                    $productosFiltrados = array_filter($listaProductos, function ($producto) use ($busqueda) {
                        return $busqueda === '' || stripos($producto->getNombre(), $busqueda) !== false;
                    });

                    // Filtrar productos por categoría "Vestidos"
                    $productosVestidos = array_filter($productosFiltrados, function ($producto) {
                        return $producto->getCategoriaProducto() === 'Vestidos';
                    });

                    // Filtrar productos por cantidad disponible mayor a 0
                    $productosVestidos = array_filter($productosVestidos, function ($producto) {
                        return $producto->getCantidad() > 0;
                    });

                    // Mostrar productos o mensaje si no hay resultados
                    if (count($productosVestidos) > 0) {
                        foreach ($productosVestidos as $producto) {
                            echo "<div class='producto'>
                                <a href='detalle_producto.php?id=" . $producto->getIdProducto() . "'>
                                    <img class='producto-imagen' src='assets/img/productos/" . $producto->getImagenUrl() . "' alt='" . htmlspecialchars($producto->getNombre()) . "'>              
                                </a>
                                <div class='producto-detalles'>
                                    <h3 class='producto-titulo'>" . htmlspecialchars($producto->getNombre()) . "</h3>
                                    <p class='producto-precio'>$" . number_format($producto->getPrecio(), 0, ',', '.') . "</p>";

                            // Verificar la modalidad del producto
                            if ($producto->getModalidadProducto() === 'Compra') {
                                // Botón "Agregar" para productos de compra
                                echo "<form method='post' action='carrito.php'>
                                        <input type='hidden' name='id_producto' value='" . $producto->getIdProducto() . "'>
                                        <input type='hidden' name='cantidad' value='1'>
                                        <button type='submit' class='producto-agregar'>Agregar</button>
                                    </form>";
                            } else {
                                // Botón "Reservar" para otros tipos de producto
                                echo "<form method='get' action='confirmar_reserva.php'>
                                        <input type='hidden' name='id_producto' value='" . $producto->getIdProducto() . "'>
                                        <button type='submit' class='producto-agregar'>Reservar</button>
                                    </form>";
                            }

                            echo "</div></div>";
                        }
                    } else {
                        echo "No hay productos disponibles en la categoría de vestidos.";
                    }
                } else {
                    echo "No hay productos disponibles en la categoría de vestidos.";
                }
                ?>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
</body>

</html>