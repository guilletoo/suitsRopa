<?php
session_start();
include_once "logica/persona.php";

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    $admin = new Persona();
    $producto = $admin->obtenerProductoPorId($id_producto);

    if ($producto != null) {
        $nombre = $producto->getNombre();
        $precio = $producto->getPrecio();
        $descripcion = $producto->getDescripcion();
        $imagen_url = $producto->getImagenUrl();
        $cantidad = $producto->getCantidad();
        $talle = $producto->getTalle();
    } else {
        // Lleva a error producto cuando se ingresa un ID no existente
        header('Location: error_producto.php');
        exit();
    }
} else {
    // Lleva a error producto cuando no se ingresa un ID
    header('Location: error_producto.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nombre); ?> – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/producto.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <div class="container">
                <div class="product-image">
                    <img src="assets/img/productos/<?php echo htmlspecialchars($imagen_url); ?>" alt="<?php echo htmlspecialchars($nombre); ?>">
                </div>
                <div class="product-details">
                    <h1 class="product-title"><?php echo htmlspecialchars($nombre); ?></h1>
                    <h2 class="product-price">
                        $<?php echo number_format($precio, 0, ',', '.'); ?>
                        <small>
                            <?php echo ($producto->getModalidadProducto() == 'Alquiler') ? ' por día' : ''; ?>
                        </small>
                    </h2>
                    <p>
                        <?php if ($talle != null) : ?>
                            Talle <strong><?php echo htmlspecialchars($talle); ?><strong>
                                <?php endif; ?>
                    </p>

                    <div class="product-buttons">
                        <?php if ($producto->getModalidadProducto() == 'Compra') : ?>
                            <form method="post" action="carrito.php">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="add-to-cart">Agregar al carrito</button>
                            </form>
                        <?php else : ?>
                            <form method="get" action="confirmar_reserva.php">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="buy-now">Reservar</button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="product-description">
                        <h2>INFORMACIÓN DEL PRODUCTO</h2>
                        <p><?php echo htmlspecialchars($descripcion); ?></p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
</body>

</html>