<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes – Suits</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <style>
        :root {
            --gris-claro: #B8B8B8;
            --sombra: 0 0 13px 0 rgba(185, 185, 185, .25);
            --clr-main: #404252;
        }

        .categorias {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 60px;
        }

        .categoria {
            cursor: pointer;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            font-weight: 700;
            color: var(--gris-claro);
            border: 2px solid transparent;
            transition: .3s ease all;
        }

        .categoria:hover {
            box-shadow: var(--clr-main);
            color: #000;
        }

        .categoria:hover path {
            fill: var(--clr-main);
        }

        .categoria i {
            font-size: 38px;
            /* Tamaño del ícono */
            margin-bottom: 10px;
            /* Espacio entre el ícono y el texto */
            color: #333;
            /* Color del ícono */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .categoria path {
            fill: var(--gris-claro);
            transition: .3s ease all;
        }

        .categoria.activa {
            border: 2px solid var(--clr-main);
            color: #000;
        }

        .categoria.activa path {
            fill: var(--clr-main);
        }

        .contenedor-preguntas {
            display: none;
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .contenedor-preguntas.activo {
            display: grid;
        }

        .contenedor-pregunta {
            background: #fff;
            padding: 40px;
            border: 2px solid transparent;
            border-radius: 10px;
            overflow: hidden;
            transition: .3s ease all;
            cursor: pointer;
        }

        .contenedor-pregunta:hover {
            box-shadow: var(--sombra);
        }

        .contenedor-pregunta.activa {
            border: 2px solid var(--clr-main);
        }

        .pregunta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            width: 100%;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .pregunta img {
            width: 14px;
        }

        .respuesta {
            color: #808080;
            line-height: 30px;
            max-height: 0;
            opacity: 0;
            transition: .3s ease all;
        }

        .contenedor-pregunta.activa .respuesta {
            opacity: 1;
            margin-top: 20px;
        }

        .contenedor-pregunta.activa img {
            transform: rotate(45deg);
        }

        @media screen and (max-width: 768px) {
            .pregunta {
                flex-direction: row;
                align-items: flex-start;
            }

            .pregunta i.mdi {
                margin-left: 10px;
                font-size: 24px;
            }

            .contenedor-pregunta {
                padding: 10px 0;
                padding-left: 10px;
                padding-right: 10px;
            }

            .categorias {
                grid-template-columns: 1fr 1fr;
            }

            .categoria {
                padding: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 5px;
            }
        }

        @media screen and (max-width: 500px) {
            .categorias {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <main>
            <h2>Preguntas Frecuentes</h2>
            <br>
            <div class="categorias" id="categorias">
                <div class="categoria activa" data-categoria="metodos-pago">
                    <i class="mdi mdi-credit-card"></i>
                    <p>Métodos de pago</p>
                </div>
                <div class="categoria" data-categoria="entregas">
                    <i class="mdi mdi-truck-delivery"></i>
                    <p>Entregas</p>
                </div>
                <div class="categoria" data-categoria="seguridad">
                    <i class="mdi mdi-shield-check"></i>
                    <p>Seguridad</p>
                </div>
                <div class="categoria" data-categoria="cuenta">
                    <i class="mdi mdi-account"></i>
                    <p>Cuenta</p>
                </div>
            </div>

            <div class="preguntas">

                <!-- Preguntas Metodos de pago -->
                <div class="contenedor-preguntas activo" data-categoria="metodos-pago">
                    <div class="contenedor-pregunta">
                        <p class="pregunta">¿Que métodos de pagos aceptan?
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </p>
                        <p class="respuesta">Aceptamos pagos a través de tarjetas, red de cobranza o transferencias bancarias.</p>
                    </div>
                </div>

                <!-- Preguntas Entregas -->
                <div class="contenedor-preguntas" data-categoria="entregas">
                    <div class="contenedor-pregunta">
                        <p class="pregunta">¿Cuál es el plazo de entrega?
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </p>
                        <p class="respuesta">El plazo de entrega es de 2 a 5 días hábiles, a partir de la fecha en que se complete el pago.</p>
                    </div>
                    <div class="contenedor-pregunta">
                        <p class="pregunta">¿Es posible cancelar el pedido?
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </p>
                        <p class="respuesta">Para cancelar el pedido, por favor contáctanos a través de <a href="contacto.php">nuestro formulario de contacto</a>.</p>
                    </div>
                    <div class="contenedor-pregunta">
                        <p class="pregunta">¿Puedo realizar un pedido por teléfono?
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </p>
                        <p class="respuesta">¡Sí! Toda nuestra información de contacto la encontrarás <a href="contacto.php">aquí</a>.</p>
                    </div>
                </div>

                <!-- Preguntas Seguridad -->
                <div class="contenedor-preguntas" data-categoria="seguridad">
                    <div class="contenedor-pregunta">
                        <p class="pregunta">¿Cuál es la política de garantía de los productos?
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </p>
                        <p class="respuesta">Todos nuestros productos tienen una garantía de 30 días contra defectos de fabricación. Si encuentras algún problema, <a href="contacto.php">contáctanos</a> y te ayudaremos a resolverlo.</p>
                    </div>
                    <div class="contenedor-pregunta">
                        <p class="pregunta">¿Qué pasa con mis datos personales?
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </p>
                        <p class="respuesta">Tus datos bancarios no se guardarán en nuestra base de datos, y tus datos en la cuenta serán correctamente encriptados para darte seguridad.</p>
                    </div>
                </div>

                <!-- Preguntas Cuenta -->
                <div class="contenedor-preguntas" data-categoria="cuenta">
                    <div class="contenedor-pregunta">
                        <p class="pregunta">¿Puedo cambiar mi contraseña?
                            <i class="mdi mdi-plus" aria-hidden="true"></i>
                        </p>
                        <p class="respuesta">Puedes cambiar tu contraseña ingresando al apartado de <a href="perfil.php">perfil</a>.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Categorias de preguntas frecuentes
        const categorias = document.querySelectorAll('#categorias .categoria');
        const contenedorPreguntas = document.querySelectorAll('.contenedor-preguntas');
        let categoriaActiva = null;

        categorias.forEach((categoria) => {
            categoria.addEventListener('click', (e) => {
                categorias.forEach((elemento) => {
                    elemento.classList.remove('activa');
                });

                e.currentTarget.classList.toggle('activa');
                categoriaActiva = categoria.dataset.categoria;


                // Activamos el contenedor de preguntas que corresponde
                contenedorPreguntas.forEach((contenedor) => {
                    if (contenedor.dataset.categoria === categoriaActiva) {
                        contenedor.classList.add('activo');
                    } else {
                        contenedor.classList.remove('activo');
                    }
                });
            });
        });

        // Preguntas frecuentes
        const preguntas = document.querySelectorAll('.preguntas .contenedor-pregunta');
        preguntas.forEach((pregunta) => {
            pregunta.addEventListener('click', (e) => {
                e.currentTarget.classList.toggle('activa');

                const respuesta = pregunta.querySelector('.respuesta');
                const alturaRealRespuesta = respuesta.scrollHeight;

                if (!respuesta.style.maxHeight) {
                    // Si esta vacio el maxHeight entonces ponemos un valor.
                    respuesta.style.maxHeight = alturaRealRespuesta + 'px';
                } else {
                    respuesta.style.maxHeight = null;
                }

                // [Opcional] Reiniciamos las demas preguntas
                preguntas.forEach((elemento) => {
                    // Solamente queremos ejecutar el codigo para las preguntas que no 
                    // sean la pregunta a la que le dimos click.
                    if (pregunta !== elemento) {
                        elemento.classList.remove('activa');
                        elemento.querySelector('.respuesta').style.maxHeight = null;
                    }
                });
            });
        });
    </script>
    <script src="assets/js/home.js"></script>
</body>

</html>