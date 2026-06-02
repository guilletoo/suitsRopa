<?php
// Obtiene el nombre del archivo actual, por ejemplo, "accesorios.php"
// Esto es útil para resaltar la sección activa en el menú de navegación.
$current_page = basename($_SERVER['PHP_SELF']);

// Contar la cantidad de productos en el carrito
$cantidad_productos_carrito = isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0;
?>

<!-- Encabezado móvil con logo y botón para abrir el menú -->
<header class="header-mobile">
    <!-- Logo en la versión móvil -->
    <img src="assets/logo.svg" width="80" height="50" viewBox="0 0 100 50" alt="Logo">
    <!-- Botón para abrir el menú en dispositivos móviles -->
    <button class="open-menu" id="open-menu">
        <i class="mdi mdi-menu"></i>
    </button>
</header>

<!-- Menú lateral -->
<aside>
    <!-- Botón para cerrar el menú en dispositivos móviles -->
    <button class="close-menu" id="close-menu">
        <i class="mdi mdi-close"></i>
    </button>

    <!-- Encabezado del menú lateral con logo -->
    <header>
        <div class="logo-container">
            <!-- Logo dentro del menú lateral -->
            <img src="assets/logo.svg" width="80" height="50" viewBox="0 0 100 50" alt="Logo">
        </div>
    </header>

    <!-- Menú de navegación -->
    <nav>
        <ul class="menu">
            <!-- Opción del menú: Inicio -->
            <li>
                <a href="index.php">
                    <button id="todos" class="boton-menu boton-categoria <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                        <i class="mdi mdi-home" style="font-size: 1.2rem;"></i> Inicio
                    </button>
                </a>
            </li>

            <!-- Opción del menú: Trajes -->
            <li>
                <a href="trajes.php">
                    <button id="trajes" class="boton-menu boton-categoria <?php echo $current_page == 'trajes.php' ? 'active' : ''; ?>">
                        <i class="mdi mdi-account-tie" style="font-size: 1.2rem;"></i> Trajes
                    </button>
                </a>
            </li>

            <!-- Opción del menú: Vestidos -->
            <li>
                <a href="vestidos.php">
                    <button id="vestidos" class="boton-menu boton-categoria <?php echo $current_page == 'vestidos.php' ? 'active' : ''; ?>">
                        <i class="mdi mdi-face-woman-shimmer" style="font-size: 1.2rem;"></i> Vestidos
                    </button>
                </a>
            </li>

            <!-- Opción del menú: Accesorios -->
            <li>
                <a href="accesorios.php">
                    <button id="accesorios" class="boton-menu boton-categoria <?php echo $current_page == 'accesorios.php' ? 'active' : ''; ?>">
                        <i class="mdi mdi-sunglasses" style="font-size: 1.2rem;"></i> Accesorios
                    </button>
                </a>
            </li>

            <!-- Opción del menú solo visible para administradores -->
            <?php if (isset($_SESSION['usuario']['estado_admin']) and $_SESSION['usuario']['estado_admin'] == 1) { ?>
                <li>
                    <a href="panel_admin.php">
                        <button id="panel-admin" class="boton-menu boton-categoria <?php echo $current_page == 'panel_admin.php' ? 'active' : ''; ?>">
                            <i class="mdi mdi-account-tie" style="font-size: 1.2rem;"></i> Panel Admin
                        </button>
                    </a>
                </li>
            <?php } ?>

            <!-- Opciones del menú para usuarios con sesión iniciada -->
            <?php if (isset($_SESSION['usuario'])) { ?>
                <!-- Perfil -->
                <li>
                    <a href="perfil.php">
                        <button id="perfil" class="boton-menu boton-categoria <?php echo $current_page == 'perfil.php' ? 'active' : ''; ?>">
                            <i class="mdi mdi-account-circle" style="font-size: 1.2rem;"></i> Perfil
                        </button>
                    </a>
                </li>
                <!-- Cerrar sesión -->
                <li>
                    <a href="logout.php">
                        <button id="cerrar-sesion" class="boton-menu boton-categoria">
                            <i class="mdi mdi-logout-variant" style="font-size: 1.2rem;"></i> Cerrar Sesión
                        </button>
                    </a>
                </li>
            <?php } else { ?>
                <!-- Opción para iniciar sesión si no está autenticado -->
                <li>
                    <a href="login.php">
                        <button id="iniciar-sesion" class="boton-menu boton-categoria">
                            <i class="mdi mdi-login-variant" style="font-size: 1.2rem;"></i> Iniciar Sesión
                        </button>
                    </a>
                </li>
            <?php } ?>

            <!-- Opción para el carrito, visible solo si no es administrador -->
            <?php if (!isset($_SESSION['usuario']['estado_admin']) or $_SESSION['usuario']['estado_admin'] != 1) { ?>
                <li>
                    <a class="boton-menu boton-carrito <?php echo $current_page == 'carrito.php' ? 'active' : ''; ?>" href="carrito.php">
                        <i class="mdi mdi-cart" style="font-size: 1.2rem;"></i> Carrito <span id="numerito" class="numerito"><?php echo $cantidad_productos_carrito; ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <!-- Pie de página -->
    <footer>
        <p class="texto-footer">&copy; <?php echo date("Y"); ?> Suits</p>
    </footer>
</aside>