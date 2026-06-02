<?php
include_once 'conexion.php';

class PersonaBD extends Conexion {

    public function iniciarSesion($cedula, $contrasena) {
        $conexion = $this->conectar();

        // Prepara la consulta
        $sql = "SELECT * FROM persona WHERE contrasena = MD5(?) AND cedula = ? AND estado_persona = 1";
        $stmt = $conexion->prepare($sql);

        // Vincula los parámetros
        $stmt->bind_param('ss', $contrasena, $cedula);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $usuario = [
                "cedula" => $row['cedula'],
                "nombre" => $row['nombre'],
                "apellido" => $row['apellido'],
                "email" => $row['email'],
                "telefono" => $row['telefono'],
                "direccion" => $row['direccion'],
                "fecha_nacimiento" => $row['fecha_nacimiento'],
                "estado_admin" => $row['estado_admin']
            ];

            return $usuario;
        } else {
            return null;
        }
    }

    public function registrarse($nombre, $apellido, $cedula, $contrasena) {

        $conexion = $this->conectar();

        // Usar MD5 directamente en la consulta para encriptar la contraseña
        $query_personas = "INSERT INTO persona (nombre, apellido, cedula, contrasena, estado_persona, estado_admin) VALUES ('$nombre', '$apellido', '$cedula', MD5('$contrasena'), 1, 0)";

        // Comprobar si ya existe un usuario con esa cedula 
        $verificar_cedula = mysqli_query($conexion, "SELECT * FROM persona WHERE cedula = '$cedula'");

        if (mysqli_num_rows($verificar_cedula) > 0) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No es posible utilizar esa cédula.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
            </script>";
        } elseif (mysqli_query($conexion, $query_personas)) {

            $query_clientes = "INSERT INTO cliente (cedula) VALUES ('$cedula')";
            mysqli_query($conexion, $query_clientes);

            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Te has registrado exitosamente.',
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
                    title: 'Error',
                    text: 'Error al crear usuario, inténtalo de nuevo.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
            </script>";
        }
        mysqli_close($conexion);
    }

    public function editarPerfil($cedula, $nombre, $apellido, $email, $telefono, $direccion, $fecha_nacimiento) {
        $conexion = $this->conectar();

        // Construye la consulta SQL
        $sql = "UPDATE persona SET nombre='$nombre', apellido='$apellido', email='$email', telefono='$telefono', direccion='$direccion' WHERE cedula='$cedula';";

        // Ejecuta la consulta
        if (mysqli_query($conexion, $sql)) {

            $_SESSION['usuario']['nombre'] = $nombre;
            $_SESSION['usuario']['apellido'] = $apellido;
            $_SESSION['usuario']['email'] = $email;
            $_SESSION['usuario']['telefono'] = $telefono;
            $_SESSION['usuario']['direccion'] = $direccion;
            $_SESSION['usuario']['fecha_nacimiento'] = $fecha_nacimiento;

            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Se editaron correctamente los datos personales.',
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
                    title: 'Error',
                    text: 'Hubo un error al editar los datos personales.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
            </script>";
        }
        mysqli_close($conexion);
    }

    public function completarDatosPersonales($cedula, $nombre, $apellido, $email, $telefono, $direccion) {
        $conexion = $this->conectar();

        // Construye la consulta SQL
        $sql = "UPDATE persona SET nombre='$nombre', apellido='$apellido', email='$email', telefono='$telefono', direccion='$direccion' WHERE cedula='$cedula';";

        // Ejecuta la consulta
        if (mysqli_query($conexion, $sql)) {

            $_SESSION['usuario']['nombre'] = $nombre;
            $_SESSION['usuario']['apellido'] = $apellido;
            $_SESSION['usuario']['email'] = $email;
            $_SESSION['usuario']['telefono'] = $telefono;
            $_SESSION['usuario']['direccion'] = $direccion;

            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Se actualizaron correctamente los datos personales.',
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
                    title: 'Error',
                    text: 'Hubo un error al actualizar los datos personales.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
            </script>";
        }
        mysqli_close($conexion);
    }

    public function verificarContrasena($cedula, $contrasena) {
        $conexion = $this->conectar();

        $sql = "SELECT contrasena FROM persona WHERE cedula='$cedula'";
        $result = mysqli_query($conexion, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            mysqli_close($conexion);
            return $contrasena == $row['contrasena'];
        }

        mysqli_close($conexion);
        return false;
    }

    public function actualizarContrasena($cedula, $hashed_password) {
        $conexion = $this->conectar();
        $sql = "UPDATE persona SET contrasena='$hashed_password' WHERE cedula='$cedula'";

        if (mysqli_query($conexion, $sql)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Contraseña actualizada correctamente.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
            </script>";
            return true;
        } else {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar la contraseña.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
            </script>";
            return false;
        }
    }

    public function cambiarEstadoCuenta($cedula, $estado) {
        $conexion = $this->conectar();
        $sql = "UPDATE persona SET estado_persona='$estado' WHERE cedula='$cedula'";

        if (mysqli_query($conexion, $sql)) {
            // Genera un mensaje de éxito con SweetAlert
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tu cuenta ha sido desactivada.',
                        text: 'Esperamos verte pronto de vuelta.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    }).then(() => {
                        // Cierra la sesión después de que el usuario cierre el SweetAlert
                        window.location.href = 'logout.php';
                    });
                });
            </script>";
        } else {
            // Genera un mensaje de error con SweetAlert
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Algo Salió Mal',
                        text: 'Hubo un problema al intentar dar de baja tu cuenta.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
            </script>";
        }

        mysqli_close($conexion);
    }

    public function obtenerProductoPorId($id_producto) {
        $conexion = $this->Conectar();
        $sql = "SELECT * FROM producto WHERE id_producto = '$id_producto'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $producto = new Producto();
            $producto->setIdProducto($row['id_producto']);
            $producto->setNombre($row['nombre']);
            $producto->setPrecio($row['precio']);
            $producto->setTalle($row['talle']);
            $producto->setCantidad($row['cantidad']);
            $producto->setDescripcion($row['descripcion']);
            $producto->setImagenUrl($row['imagen_url']);
            $producto->setEstadoProducto($row['estado_producto']);
            $producto->setModalidadProducto($row['modalidad']);
            $producto->setCategoriaProducto($row['categoria']);
            return $producto;
        } else {
            return null; // Hay que manejar luego en caso de que no haya ningun producto con el ID proporcionado
        }
    }

    public function comprar($compra) {
        $conexion = $this->conectar();

        // Verificar si el cliente existe y tiene una cuenta activa
        $cedula = $compra->getCedula();
        $sqlVerificarCliente = "SELECT * FROM cliente WHERE cedula = '$cedula' AND cedula IN (SELECT cedula FROM persona WHERE estado_persona = 1)";
        $resultadoVerificacion = mysqli_query($conexion, $sqlVerificarCliente);

        if (mysqli_num_rows($resultadoVerificacion) === 0) {
            echo "El cliente no está activo o no existe.";
            mysqli_close($conexion);
            return false;
        }

        // Registrar la compra
        $total = $compra->getTotal();
        $sqlRegistrarCompra = "INSERT INTO compra (cedula, fecha_compra, total) VALUES ('$cedula', '" . $compra->getFechaCompra() . "', '$total')";

        if (mysqli_query($conexion, $sqlRegistrarCompra)) {
            $id_compra = mysqli_insert_id($conexion); // Obtener el ID de la compra recién creada
            $_SESSION['id_compra'] = $id_compra; // Solo guarda el ID de compra

            // Registrar cada producto en la tabla compras_detalles
            foreach ($compra->getProductos() as $id_producto => $detalles) {
                $cantidad = $detalles['cantidad'];
                $precio_unitario = $detalles['precio'];
                $subtotal = $cantidad * $precio_unitario;

                $sqlRegistrarDetalle = "INSERT INTO compra_detalles (id_compra, id_producto, cantidad, precio_unitario, subtotal) VALUES ('$id_compra', '$id_producto', '$cantidad', '$precio_unitario', '$subtotal')";
                mysqli_query($conexion, $sqlRegistrarDetalle);
            }

            // Actualizar el stock del producto
            foreach ($compra->getProductos() as $id_producto => $detalles) {
                $cantidad = $detalles['cantidad'];
                $sqlActualizarStock = "UPDATE producto SET cantidad = cantidad - $cantidad WHERE id_producto = '$id_producto'";
                mysqli_query($conexion, $sqlActualizarStock);
            }

            // Mostrar SweetAlert de compra exitosa y redirigir
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Compra exitosa!',
                        text: 'Tu compra ha sido realizada con éxito. Redirigiendo al historial de pedidos...',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    }).then(function() {
                        window.location.href = 'historial_pedidos.php';
                    });
                });
            </script>";

            return true;
        } else {
            echo "Error al registrar la compra.";
            mysqli_close($conexion);
            return false;
        }
    }

    public function obtenerHistorialCompras($cedula) {
        $conexion = $this->conectar();

        $sql = "SELECT c.id_compra, c.fecha_compra, c.total FROM compra c WHERE c.cedula = '$cedula' ORDER BY c.fecha_compra DESC";
        $resultado = mysqli_query($conexion, $sql);

        $compras = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $compras[] = $fila;
        }

        mysqli_close($conexion);


        if (!empty($compras)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['id_compra'] = $compras[0]['id_compra'];
            $_SESSION['fecha_compra'] = $compras[0]['fecha_compra'];
        }

        return $compras;
    }

    public function obtenerDetallesCompra($id_compra) {
        $conexion = $this->conectar();

        $sql = "SELECT p.nombre AS nombre_producto, cd.cantidad, cd.precio_unitario, cd.subtotal, c.total 
                FROM compra_detalles cd
                JOIN producto p ON cd.id_producto = p.id_producto
                JOIN compra c ON cd.id_compra = c.id_compra
                WHERE cd.id_compra = '$id_compra'";

        $resultado = mysqli_query($conexion, $sql);
        $detalles = [];

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $detalles[] = $fila;
        }

        mysqli_close($conexion);
        return $detalles;
    }

    public function reservar($reserva) {
        $conexion = $this->conectar();

        // Obtén los datos de la reserva
        $cedula = $reserva->getCedula();
        $id_producto = $reserva->getIdProducto();
        $fecha_retiro = $reserva->getFechaRetiro();
        $fecha_devolucion = $reserva->getFechaDevolucion();

        // Verifica si el producto está disponible para alquiler
        $verificar_producto = "SELECT cantidad FROM producto WHERE id_producto = '$id_producto'";
        $resultado = mysqli_query($conexion, $verificar_producto);
        $producto = mysqli_fetch_assoc($resultado);

        if ($producto && isset($producto['cantidad']) && $producto['cantidad'] > 0) {
            // Insertar en la tabla alquiler
            $query_alquiler = "INSERT INTO alquiler (fecha_retiro, fecha_devolucion, id_producto, cedula) 
                               VALUES ('$fecha_retiro', '$fecha_devolucion', '$id_producto', '$cedula')";

            if (mysqli_query($conexion, $query_alquiler)) {
                // Actualiza la cantidad del producto
                $nueva_cantidad = $producto['cantidad'] - 1;
                $actualizar_producto = "UPDATE producto SET cantidad = '$nueva_cantidad' WHERE id_producto = '$id_producto'";
                mysqli_query($conexion, $actualizar_producto);

                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Reserva realizada con éxito!',
                            text: 'Para confirmar la reserva, por favor diríjase a la tienda física.',
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        }).then(function() {
                            window.location.href = 'historial_pedidos.php';
                        });
                    });
                </script>";
            } else {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al realizar el alquiler, inténtalo de nuevo.',
                        customClass: { confirmButton: 'swal2-confirm' }
                    });
                });
                </script>";
            }
        } else {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No hay disponibilidad para el producto seleccionado.',
                    customClass: { confirmButton: 'swal2-confirm' }
                });
            });
            </script>";
        }

        mysqli_close($conexion);
    }

    public function obtenerHistorialAlquileres($cedula) {
        $conexion = $this->conectar();

        // Consulta SQL para obtener los alquileres
        $sql = "SELECT a.id_alquiler, a.fecha_retiro, a.fecha_devolucion, a.id_producto 
                FROM alquiler a 
                WHERE a.cedula = '$cedula' 
                ORDER BY a.fecha_retiro DESC";

        $resultado = mysqli_query($conexion, $sql);

        $alquileres = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $alquileres[] = $fila;
        }

        mysqli_close($conexion);

        if (!empty($alquileres)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['id_alquiler'] = $alquileres[0]['id_alquiler'];
            $_SESSION['fecha_retiro'] = $alquileres[0]['fecha_retiro'];
            $_SESSION['fecha_devolucion'] = $alquileres[0]['fecha_devolucion'];
        }

        return $alquileres;
    }

    // Esto se usa para listar todas las compras de todos los clientes en Gestionar Pedidos
    public function obtenerTodasLasCompras() {
        // Conexión a la base de datos
        $conexion = $this->conectar();

        // Consulta SQL para obtener las compras
        $sql = "
            SELECT DISTINCT 
                c.id_compra, 
                c.fecha_compra, 
                c.total, 
                p.cedula,
                p.nombre, 
                p.apellido, 
                p.cedula, 
                p.direccion,
                p.telefono,
                p.email
            FROM 
                compra c
            JOIN 
                persona p ON c.cedula = p.cedula
            ORDER BY 
                c.fecha_compra DESC;
        ";

        // Ejecución de la consulta
        $resultado = mysqli_query($conexion, $sql);

        // Almacenamiento de las compras en un arreglo
        $compras = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $compras[] = $fila;
        }

        // Cierre de la conexión
        mysqli_close($conexion);

        // Retorno de la lista de compras
        return $compras;
    }

    public function obtenerTodosLosAlquileres() {
        // Conexión a la base de datos
        $conexion = $this->conectar();

        // Consulta SQL para obtener los alquileres
        $sql = "
            SELECT DISTINCT 
                a.id_alquiler,
                a.fecha_retiro,
                a.fecha_devolucion,
                p.cedula,
                p.nombre, 
                p.apellido, 
                p.cedula, 
                p.direccion,
                p.telefono,
                p.email,
                pr.id_producto
            FROM 
                alquiler a
            JOIN 
                persona p ON a.cedula = p.cedula
            JOIN 
                producto pr ON a.id_producto = pr.id_producto
            ORDER BY 
                a.fecha_retiro DESC;
        ";

        // Ejecución de la consulta
        $resultado = mysqli_query($conexion, $sql);

        // Almacenamiento de los alquileres en un arreglo
        $alquileres = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $alquileres[] = $fila;
        }

        // Cierre de la conexión
        mysqli_close($conexion);

        // Retorno de la lista de alquileres
        return $alquileres;
    }
}
