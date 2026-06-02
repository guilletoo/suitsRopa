<?php
session_start();
include 'logica/producto.php';
include_once "logica/admin.php";
include_once "logica/cargar_imagen.php";

// Verifica si la sesión está iniciada y si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['estado_admin'] != 1) {
    header('Location: index.php'); // Redirige si no está autenticado o no es admin
    exit();
}

if (isset($_POST['publicar_producto'])) {
    $producto = new Producto();
    $nombre_producto = $_POST['nombre_producto'];
    $precio_producto = $_POST['precio_producto'];
    $talle_producto = strtoupper($_POST['talle_producto']);
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $modalidad_producto = $_POST['modalidad_producto'];
    $categoria_producto = $_POST['categoria_producto'];
    $nombreImagen = cargarImagen();

    // Verificación del nombre (debe ser texto)
    if (is_numeric($nombre_producto)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El nombre debe contener solo letras.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Verificación del precio (debe ser numérico)
    } elseif (!is_numeric($precio_producto)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El precio debe contener solo números.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (!is_numeric($cantidad)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La cantidad debe contener solo números.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Verificación de longitud máxima del nombre
    } elseif (strlen($nombre_producto) > 50) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El nombre debe tener un máximo de 50 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Verificación de longitud máxima del talle


    } elseif (strlen($talle_producto) > 5) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El talle debe tener un máximo de 5 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Verificación de longitud máxima de la descripción
    } elseif (strlen($descripcion) > 1000) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La descripción debe tener un máximo de 1000 caracteres.',
                customClass: {
                    confirmButton: 'swal2-confirm'
                }
            });
        });
    </script>";
        // Verificación de la imagen
    } elseif ($nombreImagen == null) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se ha cargado ninguna imagen.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Si todas las verificaciones son correctas, carga el producto
    } elseif ($cantidad < 1) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La cantidad debe de ser mayor a 0.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($precio_producto < 1) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El precio debe de ser mayor a 0.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";

        // Si todas las verificaciones son correctas, carga el producto
    } else {
        $producto->setNombre($nombre_producto);
        $producto->setPrecio($precio_producto);
        $producto->setTalle($talle_producto);
        $producto->setCantidad($cantidad);
        $producto->setDescripcion($descripcion);
        $producto->setCategoriaProducto($categoria_producto);
        $producto->setImagenUrl($nombreImagen);
        $producto->setModalidadProducto($modalidad_producto);

        $ad = new Admin();
        $ad->cargarProducto($producto);

        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Producto publicado correctamente.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    }
}

if (isset($_POST['modificar'])) {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $talle = strtoupper($_POST['talle']);
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $categoria_producto = $_POST['categoria_producto2'];
    $nombreImagen2 = cargarImagen2();

    if (empty($nombre) || empty($precio) || empty($cantidad) || empty($descripcion) || empty($categoria_producto) || empty($nombreImagen2)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios.',
                customClass: {
                    confirmButton: 'swal2-confirm'
                }
            });
        </script>";
    } elseif (is_numeric($nombre) || strlen($nombre) > 50) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El nombre debe contener solo letras y tener menos de 50 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Verificación del precio (debe ser numérico)
    } elseif (!is_numeric($precio) || $precio > 65536) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El precio debe ser un número menor a 65536.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Verificación del talle
    } elseif (strlen($talle) > 5) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El talle debe tener como máximo 5 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (!is_numeric($cantidad) || strlen($cantidad) > 65536) { // Verificación de la cantidad (debe ser numérica)
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La cantidad debe ser un número y no puede superar las 65536 unidades.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($descripcion) > 600) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La descripción no debe superar los 600 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
        // Verificación de la imagen
    } elseif (empty($nombreImagen2)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debes seleccionar una imagen para el producto.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($cantidad < 1) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La cantidad debe de ser mayor a 0.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($precio < 1) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El precio debe de ser mayor a 0.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";

        // Si todas las verificaciones son correctas, carga el producto
    } else {
        // Si todo está bien, actualizar el producto.
        $producto = new Producto();
        $producto->setIdProducto($id_producto);
        $producto->setNombre($nombre);
        $producto->setPrecio($precio);
        $producto->setTalle($talle);
        $producto->setCantidad($cantidad);
        $producto->setDescripcion($descripcion);
        $producto->setCategoriaProducto($categoria_producto);
        $producto->setImagenUrl($nombreImagen2);
        $admin = new Admin();

        if ($admin->modificarProducto($producto)) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Producto modificado correctamente.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un error al modificar el producto.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
            </script>";
        }
    }
}

// Obtener todos los productos de la base de datos
$productos = [];
$ad = new Admin();
$productos = $ad->listarProducto();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link rel="stylesheet" href="assets/css/gestionar_productos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <h2 class="titulo-principal">Gestionar Productos</h2>
            <div class="form-container">
                <h2 class="form-title">Publicar Producto</h2>

                <!-- Formulario para publicar producto -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre_producto">Nombre</label>
                        <input type="text" id="nombre_producto" name="nombre_producto" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_producto">Precio</label>
                        <input min="1" type="text" id="precio_producto" name="precio_producto" required>
                    </div>
                    <div class="form-group">
                        <label for="talle_producto">Talle</label>
                        <input type="text" id="talle_producto" name="talle_producto" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                        <label for="imagen_url">Imagen</label>
                        <div class="file-upload">
                            <input type="file" id="imagen_url" name="imagen_url" onchange="updateFileName(this, 'file-name')" required>
                            <input type="text" id="file-name" placeholder="Ningún archivo seleccionado" readonly>
                            <button type="button" class="file-upload-btn" onclick="document.getElementById('imagen_url').click();">Seleccionar</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input min="1" type="number" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <div class="content-select">
                            <label>Modalidad</label>
                            <select name="modalidad_producto" required>
                                <option value="" disabled selected>Seleccione una Modalidad</option>
                                <option value="Alquiler">Alquiler</option>
                                <option value="Compra">Compra</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="content-select">
                            <label>Categoria</label>
                            <select name="categoria_producto" required>
                                <option value="" disabled selected>Seleccione una Categoria</option>
                                <option value="Trajes">Trajes</option>
                                <option value="Vestidos">Vestidos</option>
                                <option value="Accesorios">Accesorios</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="update-profile-btn" name="publicar_producto">Publicar Producto</button>
                </form>
            </div>

            <!-- Listado de productos -->
            <h2 class="form-title">Listado de Productos</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Talle</th>
                        <th>Cantidad</th>
                        <th>Imagen</th>
                        <th>Modalidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if (!empty($productos)): ?>
                        <?php foreach ($productos as $producto): ?>
                            <tr>
                                <td>
                                    <?php echo $producto->getNombre(); ?>
                                </td>
                                <td>
                                    <?php echo '$' . number_format($producto->getPrecio(), 0, ',', '.'); ?>
                                </td>
                                <td>
                                    <?php echo $producto->getTalle(); ?>
                                </td>
                                <td>
                                    <?php echo $producto->getCantidad(); ?>
                                </td>
                                <td><img src="assets/img/productos/<?php echo $producto->getImagenUrl(); ?>" alt="<?php echo $producto->getNombre(); ?>" width="50"></td>
                                <td>
                                    <?php echo $producto->getModalidadProducto(); ?>
                                </td>
                                <td>
                                    <?php echo $producto->getEstadoProducto() == 1 ? 'Activo' : 'Inactivo'; ?>
                                </td>
                                <td class="actions">
                                    <button class="action-btn edit-btn" title="Editar Producto" onclick="mostrar('<?php echo $producto->getIdProducto(); ?>', '<?php echo $producto->getNombre(); ?>', '<?php echo $producto->getPrecio(); ?>', '<?php echo $producto->getTalle(); ?>', '<?php echo $producto->getCantidad(); ?>', '<?php echo $producto->getDescripcion(); ?>', '<?php echo $producto->getCategoriaProducto(); ?>')">
                                        <span class="mdi mdi-square-edit-outline" aria-label="Editar"></span>
                                    </button>
                                    <button class="action-btn" title="<?php echo $producto->getEstadoProducto() == 1 ? 'Desactivar Producto' : 'Activar Producto'; ?>"
                                        onclick="cambiarEstadoProducto('<?php echo $producto->getIdProducto(); ?>', '<?php echo $producto->getEstadoProducto(); ?>')">
                                        <span class="mdi <?php echo $producto->getEstadoProducto() == 1 ? 'mdi-checkbox-marked-circle-outline' : 'mdi-checkbox-blank-circle-outline'; ?>" aria-label="Cambiar Estado Producto"></span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No hay productos disponibles</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <!-- Modal para modificar producto -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrar()">
                        <i class="mdi mdi-close"></i>
                    </span>
                    <h2 class="form-title">Modificar Producto</h2>
                    <form id="formModificar" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="id_producto" name="id_producto">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input min="1" type="number" id="precio" name="precio" required>
                        </div>
                        <div class="form-group">
                            <label for="talle">Talle:</label>
                            <input type="text" id="talle" name="talle">
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad:</label>
                            <input min="1" type="number" id="cantidad_modal" name="cantidad" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea id="descripcion_modal" name="descripcion" required></textarea>
                        </div>
                        <div class="form-group">
                            <div class="content-select">
                                <label>Categoria</label>
                                <select name="categoria_producto2" id="categoria_producto2" required>
                                    <option value="" disabled selected>Seleccione una Categoria</option>
                                    <option value="Trajes">Trajes</option>
                                    <option value="Vestidos">Vestidos</option>
                                    <option value="Accesorios">Accesorios</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="estado" value="1">
                        <div class="form-group">
                            <label for="imagen_url2">Imagen</label>
                            <div class="file-upload">
                                <input type="file" id="imagen_url2" name="imagen_url2" onchange="updateFileName(this, 'file-name_modal')" required>
                                <input type="text" id="file-name_modal" placeholder="Ningún archivo seleccionado" readonly>
                                <button type="button" class="file-upload-btn" onclick="document.getElementById('imagen_url2').click();">Seleccionar</button>
                            </div>
                        </div>
                        <button type="submit" class="update-profile-btn" id="modificar" name="modificar">Modificar Producto</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/home.js"></script>
    <script>
        function cambiarEstadoProducto(id, estado) {
            console.log(id, estado);
            var obAjax = new XMLHttpRequest();

            obAjax.onreadystatechange = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Estado modificado correctamente.',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    } else {
                        swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al cambiar el estado del producto.',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    }
                }
            };

            obAjax.onerror = function() {
                alert("Error de red al realizar la solicitud.");
            };

            obAjax.open('POST', 'persistencia/admin_bd.php', true);
            obAjax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            obAjax.send('id_producto=' + encodeURIComponent(id) + '&estado=' + encodeURIComponent(estado));
        }

        function updateFileName(input, targetId) {
            const fileName = input.files[0] ? input.files[0].name : "Ningún archivo seleccionado";
            document.getElementById(targetId).value = fileName;
        }

        var modal = document.getElementById("myModal");

        function mostrar(id, nombre, precio, talle, cantidad, descripcion, categoria, imagen_url2) {
            modal.style.display = "block"; // Muestra el modal
            modal.classList.add("show"); // Agrega la clase show
            document.getElementById("id_producto").value = id;
            document.getElementById("nombre").value = nombre;
            document.getElementById("precio").value = precio;
            document.getElementById("talle").value = talle;
            document.getElementById("cantidad_modal").value = cantidad;
            document.getElementById("descripcion_modal").value = descripcion;
            document.getElementById("categoria_producto2").value = categoria;
            document.getElementById("imagen_url2").value = imagen_url2;
            console.log(descripcion);
        }

        function cerrar() {
            modal.classList.remove("show"); // Quita la clase show
            setTimeout(() => {
                modal.style.display = "none"; // Oculta el modal después de la animación
            }, 300); // Debe coincidir con el tiempo de la transición
        }
    </script>
</body>

</html>