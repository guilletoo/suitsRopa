<?php
include_once 'logica/persona.php';
session_start(); // Inicia la sesión para manejar datos temporales

if (isset($_POST['login'])) {
    $cedula = $_POST['cedula'];
    $contrasena = $_POST['contrasena'];

    // Guardar en la sesión los datos del login
    $_SESSION['cedula_login'] = $cedula;
    $_SESSION['contrasena_login'] = $contrasena;  // Guarda la contraseña del login

    $a = new Persona();
    $a->setCedula($cedula);
    $a->setContrasena($contrasena);
    $usuario = $a->iniciarSesion();

    if ($usuario != null) {
        session_unset(); // Limpia la sesión en caso de éxito
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit();
    } elseif (!is_numeric($cedula)) {
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
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Credenciales incorrectas. Por favor, verifica tu cédula y contraseña.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    }
}

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Guardar los datos del registro en la sesión
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido'] = $apellido;
    $_SESSION['cedula_registro'] = $cedula;
    $_SESSION['contrasena_registro'] = $contrasena;
    $_SESSION['confirmar_contrasena_registro'] = $confirmar_contrasena;

    if (empty($nombre) || empty($apellido) || empty($cedula) || empty($contrasena) || empty($confirmar_contrasena)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor, completa todos los campos.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (is_numeric($nombre) || is_numeric($apellido)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'El nombre y el apellido deben contener únicamente letras.',
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
                    text: 'El nombre y el apellido deben contener un máximo de 30 caracteres.',
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
    } elseif (strlen($contrasena) > 50) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La contraseña debe tener 50 o menos caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($contrasena) < 8) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La contraseña debe tener al menos 8 caracteres.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($contrasena !== $confirmar_contrasena) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Las contraseñas no coinciden.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (!is_numeric($cedula)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La cédula solo debe contener números.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($cedula) < 1) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La cédula debe contener más de 1 caracter numérico.',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif (strlen($cedula) > 8) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La cedula debe de contener menos de 8 caracteres numericos·',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } elseif ($cedula < 1) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'La cedula debe de ser mayor a 1·',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
        </script>";
    } else {
        $a = new Persona();
        $a->setNombre($nombre);
        $a->setApellido($apellido);
        $a->setCedula($cedula);
        $a->setContrasena($contrasena);
        $usuario = $a->registrarse();
        session_unset(); // Limpia la sesión en caso de éxito
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <title>Ingresar & Registro – Suits</title>
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <div class="signin-signup">

            <!-- Formulario de inicio de sesión -->
            <form action="" method="post" class="sign-in-form">
                <h2 class="title">Iniciar Sesión</h2>
                <div class="input-field">
                    <i class="mdi mdi-card-account-details"></i>
                    <input type="number" name="cedula" placeholder="Cédula de Identidad" required value="<?php echo isset($_SESSION['cedula_login']) ? $_SESSION['cedula_login'] : ''; ?>">
                </div>
                <div class="input-field">
                    <i class="mdi mdi-lock"></i>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" required value="<?php echo isset($_SESSION['contrasena_login']) ? $_SESSION['contrasena_login'] : ''; ?>">
                    <i class="mdi mdi-eye" id="togglePassword" style="cursor: pointer;" title="Mostrar Contraseña"></i>
                </div>
                <input type="submit" name="login" value="Ingresar" class="btn">
                <p class="account-text">¿No tienes una cuenta? <a href="#" id="sign-up-btn2">Registrate</a></p>
                <p class="account-text">¿Volver a inicio? <a href="index.php" id="sign-up-btn2">Volver</a></p>
            </form>

            <!-- Formulario de registro -->
            <form action="" method="post" class="sign-up-form">
                <h2 class="title">Registrate</h2>
                <div class="input-field">
                    <i class="mdi mdi-account"></i>
                    <input type="text" name="nombre" placeholder="Nombre" required autocomplete="off" value="<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''; ?>">
                </div>
                <div class="input-field">
                    <i class="mdi mdi-account"></i>
                    <input type="text" name="apellido" placeholder="Apellido" required autocomplete="off" value="<?php echo isset($_SESSION['apellido']) ? $_SESSION['apellido'] : ''; ?>">
                </div>
                <div class="input-field">
                    <i class="mdi mdi-card-account-details"></i>
                    <input type="number" minlength="1" maxlength="8" name="cedula" placeholder="Cédula de Identidad" required autocomplete="off" value="<?php echo isset($_SESSION['cedula_registro']) ? $_SESSION['cedula_registro'] : ''; ?>">
                </div>
                <div class="input-field">
                    <i class="mdi mdi-lock"></i>
                    <input type="password" id="contrasena_reg" name="contrasena" placeholder="Contraseña" minlength="8" maxlength="50" required autocomplete="off" value="<?php echo isset($_SESSION['contrasena_registro']) ? $_SESSION['contrasena_registro'] : ''; ?>">
                    <i class="mdi mdi-eye" id="togglePasswordReg" style="cursor: pointer;" title="Mostrar Contraseña"></i>
                </div>
                <div class="input-field">
                    <i class="mdi mdi-lock"></i>
                    <input type="password" id="confirmar_contrasena_reg" name="confirmar_contrasena" minlength="8" maxlength="50" placeholder="Confirmar contraseña" minlength="8" required autocomplete="off" value="<?php echo isset($_SESSION['confirmar_contrasena_registro']) ? $_SESSION['confirmar_contrasena_registro'] : ''; ?>">
                    <i class="mdi mdi-eye" id="toggleConfirmPasswordReg" style="cursor: pointer;" title="Mostrar Contraseña"></i>
                </div>
                <input type="submit" name="registrar" value="Registrarse" class="btn">
                <p class="account-text">¿Ya tienes una cuenta? <a href="#" id="sign-in-btn2">Iniciar Sesión</a></p>
                <p class="account-text">¿Volver a inicio? <a href="index.php" id="sign-up-btn2">Volver</a></p>
            </form>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>¿Ya te habías registrado antes?</h3>
                    <p></p>
                    <button class="btn" id="sign-in-btn">Iniciar Sesión</button>
                    <br>
                    <a href="index.php"><button class="btn-volver">Volver a inicio</button></a>
                </div>
            </div>

            <div class="panel right-panel">
                <div class="content">
                    <h3>¿Aún no tenés una cuenta?</h3>
                    <p></p>
                    <button class="btn" id="sign-up-btn">Registrarse</button>
                    <br>
                    <a href="index.php"><button class="btn-volver">Volver a inicio</button></a>
                </div>
            </div>

        </div>
    </div>

    <script src="assets/js/login.js"></script>
    <!-- Script para alternar la visibilidad de las contraseñas -->
    <script>
        // Alternar visibilidad de la contraseña en Iniciar Sesión
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#contrasena');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('mdi-eye-off'); // Cambiar el ícono
        });

        // Alternar visibilidad de la contraseña en Registro (primera)
        const togglePasswordReg = document.querySelector('#togglePasswordReg');
        const passwordInputReg = document.querySelector('#contrasena_reg');

        togglePasswordReg.addEventListener('click', function() {
            const type = passwordInputReg.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputReg.setAttribute('type', type);
            this.classList.toggle('mdi-eye-off');
        });

        // Alternar visibilidad de la confirmación de contraseña en Registro
        const toggleConfirmPasswordReg = document.querySelector('#toggleConfirmPasswordReg');
        const confirmPasswordInputReg = document.querySelector('#confirmar_contrasena_reg');

        toggleConfirmPasswordReg.addEventListener('click', function() {
            const type = confirmPasswordInputReg.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInputReg.setAttribute('type', type);
            this.classList.toggle('mdi-eye-off');
        });
    </script>
</body>

</html>