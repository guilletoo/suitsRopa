<?php
include_once 'conexion.php';

class AdminBD extends Conexion {

    public function agregarAdmin($cedula) {
        $conexion = $this->conectar();

        // Primero, verifica si el administrador ya existe y está habilitado
        $verificar_admin = mysqli_query($conexion, "SELECT * FROM persona WHERE cedula = '$cedula' AND estado_admin = 1");

        if (mysqli_num_rows($verificar_admin) > 0) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Número de Cédula Duplicado',
                        text: 'Lamentablemente, ya existe un administrador con ese número de cédula. Por favor, verifica el número ingresado o utiliza uno diferente.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
            </script>";
        } else {
            // Verifica si el administrador existe pero no está habilitado
            $verificar_admin_no_habilitado = mysqli_query($conexion, "SELECT * FROM persona WHERE cedula = '$cedula'");

            if (mysqli_num_rows($verificar_admin_no_habilitado) > 0) {
                // Actualiza el estado del administrador a 1 (habilitado)
                $query_admin = "UPDATE persona SET estado_admin = 1 WHERE cedula = '$cedula'";
                if (mysqli_query($conexion, $query_admin)) {
                    // Agrega el administrador a la tabla administrador
                    $query_insert_admin = "INSERT INTO administrador (cedula) VALUES ('$cedula')";
                    mysqli_query($conexion, $query_insert_admin);

                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Administrador Agregado',
                                text: 'El administrador ha sido agregado con éxito.',
                                customClass: {
                                    confirmButton: 'swal2-confirm'
                                }
                            });
                        });
                    </script>";
                } else {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al Agregar Administrador',
                                text: 'Lamentablemente, hubo un problema al intentar agregar al administrador.',
                                customClass: {
                                    confirmButton: 'swal2-confirm'
                                }
                            });
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Administrador No Encontrado',
                            text: 'No se encontró ningún administrador con el número de cédula proporcionado.',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    });
                </script>";
            }
        }
    }

    public function eliminarAdmin($cedula) {
        $conexion = $this->conectar();

        // Primero, verifica si el administrador está habilitado
        $verificar_admin = mysqli_query($conexion, "SELECT * FROM persona WHERE cedula = '$cedula' AND estado_admin = 1");

        if (mysqli_num_rows($verificar_admin) > 0) {
            // Actualiza el estado del administrador a 0 (deshabilitado)
            $query_admin = "UPDATE persona SET estado_admin = 0 WHERE cedula = '$cedula'";
            if (mysqli_query($conexion, $query_admin)) {
                // Elimina el administrador de la tabla administrador
                $query_delete_admin = "DELETE FROM administrador WHERE cedula = '$cedula'";
                mysqli_query($conexion, $query_delete_admin);

                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Administrador Eliminado',
                            text: 'El administrador ha sido eliminado con éxito.',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al Eliminar Administrador',
                            text: 'Lamentablemente, hubo un problema al intentar eliminar el administrador. Por favor, intenta de nuevo más tarde.',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Administrador No Encontrado',
                        text: 'No se encontró ningún administrador con el número de cédula proporcionado. Verifica el número ingresado o intenta con otro.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
            </script>";
        }
    }

    public function cargarProductos($nombre, $precio, $talle, $cantidad, $descripcion, $imagen_url, $modalidad_producto, $categoria_producto) {
        $conexion = $this->conectar();
        $sql = "INSERT INTO producto (nombre, precio, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
                VALUES ('$nombre', '$precio', '$talle', '$cantidad', '$descripcion', '$imagen_url', 1, '$modalidad_producto', '$categoria_producto')";

        if ($conexion->query($sql)) {
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
        $this->desconectar();
    }

    public function modificarProducto($id_producto, $nombre, $precio, $talle, $cantidad, $descripcion, $imagen_url, $categoria_producto) {
        $conexion = $this->conectar();

        $sqlProducto = "UPDATE producto SET nombre='$nombre', precio='$precio', talle='$talle', cantidad='$cantidad',
        descripcion='$descripcion', imagen_url='$imagen_url', estado_producto='1', categoria='$categoria_producto'";

        $sqlProducto .= " WHERE id_producto='$id_producto';";

        if ($conexion->query($sqlProducto)) {
            return true;
        } else {
            echo "Error: " . $sqlProducto . "<br>" . $conexion->error;
        }
        $this->desconectar();
    }

    public function listarProductos() {
        $conexion = $this->Conectar();
        $sql = "SELECT * FROM producto";

        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $listaProductos = array();

            while ($row = $result->fetch_assoc()) {
                $l = new Producto();
                $l->setIdProducto($row['id_producto']);
                $l->setNombre($row['nombre']);
                $l->setPrecio($row['precio']);
                $l->setTalle($row['talle']);
                $l->setCantidad($row['cantidad']);
                $l->setDescripcion($row['descripcion']);
                $l->setImagenUrl($row['imagen_url']);
                $l->setEstadoProducto($row['estado_producto']);
                $l->setModalidadProducto($row['modalidad']);
                $l->setCategoriaProducto($row['categoria']);
                $listaProductos[] = $l;
            }
            return $listaProductos;
        } else {
            return null;
        }
    }

    public function listarProductosActivos() {
        $conexion = $this->Conectar();
        $sql = "SELECT * FROM producto WHERE estado_producto = 1";

        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $listaProductos = array();

            while ($row = $result->fetch_assoc()) {
                $l = new Producto();
                $l->setIdProducto($row['id_producto']);
                $l->setNombre($row['nombre']);
                $l->setPrecio($row['precio']);
                $l->setTalle($row['talle']);
                $l->setCantidad($row['cantidad']);
                $l->setDescripcion($row['descripcion']);
                $l->setImagenUrl($row['imagen_url']);
                $l->setEstadoProducto($row['estado_producto']);
                $l->setModalidadProducto($row['modalidad']);
                $l->setCategoriaProducto($row['categoria']);
                $listaProductos[] = $l;
            }
            return $listaProductos;
        } else {
            return null;
        }
    }

    public function listarAdministradores() {
        $conexion = $this->conectar();
        $sql = "SELECT cedula, nombre, apellido FROM persona WHERE estado_admin = 1 ORDER BY estado_admin DESC";

        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $listaAdministradores = array();

            while ($row = $result->fetch_assoc()) {
                $admin = array();
                $admin['cedula'] = $row['cedula'];
                $admin['nombre'] = $row['nombre'];
                $admin['apellido'] = $row['apellido'];
                $listaAdministradores[] = $admin;
            }

            return $listaAdministradores;
        } else {
            return null; // Retorna nada si no se encuentran administradores
        }

        $this->desconectar();
    }

    public function obtenerPedidos() {
        // Llamar al método conectar() para asegurarnos de tener una conexión válida
        $conexion = $this->conectar();

        // Consultar las compras
        $sql_compras = "
            SELECT 
                'compra' AS tipo, 
                c.id_compra AS id_pedido, 
                c.fecha_compra AS fecha, 
                c.total AS total, 
                p.nombre AS nombre_usuario, 
                p.apellido AS apellido_usuario
            FROM compra c
            JOIN persona p ON c.cedula = p.cedula
            ORDER BY c.fecha_compra DESC";

        // Consultar los alquileres
        $sql_alquileres = "
            SELECT 
                'alquiler' AS tipo, 
                a.id_alquiler AS id_pedido, 
                a.fecha_retiro AS fecha, 
                NULL AS total, 
                p.nombre AS nombre_usuario, 
                p.apellido AS apellido_usuario
            FROM alquiler a
            JOIN persona p ON a.cedula = p.cedula
            ORDER BY a.fecha_retiro DESC";

        // Ejecutar las consultas y verificar si hay errores
        $resultado_compras = $conexion->query($sql_compras);
        if (!$resultado_compras) {
            die("Error en la consulta de compras: " . $conexion->error);
        }

        $resultado_alquileres = $conexion->query($sql_alquileres);
        if (!$resultado_alquileres) {
            die("Error en la consulta de alquileres: " . $conexion->error);
        }

        // Crear un array para almacenar los pedidos
        $pedidos = [];

        // Obtener las compras
        while ($row = $resultado_compras->fetch_assoc()) {
            $pedidos[] = $row;
        }

        // Obtener los alquileres
        while ($row = $resultado_alquileres->fetch_assoc()) {
            $pedidos[] = $row;
        }

        // Ordenar los pedidos por fecha (de más reciente a más antiguo)
        usort($pedidos, function ($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });

        return $pedidos;
    }
}

if (isset($_POST['id_producto'])) {

    $id_producto = $_POST['id_producto'];
    $estado = $_POST['estado'];

    $conexion = new Conexion();

    if ($estado == 1) {

        $sql = "UPDATE producto SET estado_producto = 0 WHERE id_producto = '" . $id_producto . "'";
        return mysqli_query(mysql: $conexion->conectar(), query: $sql);
    } else {
        $sql = "UPDATE producto SET estado_producto = 1 WHERE id_producto = '" . $id_producto . "'";
        return mysqli_query(mysql: $conexion->conectar(), query: $sql);
    }
}
