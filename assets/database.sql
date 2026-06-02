-- Crear la base de datos y acceder a ella
CREATE DATABASE suits;
USE suits;

-- Crear tabla persona
CREATE TABLE persona (
    nombre VARCHAR(30),
    apellido VARCHAR(30),
    cedula INT NOT NULL,
    email VARCHAR(50),
    telefono VARCHAR(15),
    direccion VARCHAR(50),
    fecha_nacimiento DATE,
    contrasena VARCHAR(50),
    estado_persona BOOLEAN,
    estado_admin BOOLEAN, 
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (cedula)
);

-- Crear tabla cliente
CREATE TABLE cliente (
    cedula INT,
    PRIMARY KEY (cedula),
    FOREIGN KEY (cedula) REFERENCES persona (cedula)
);

-- Crear tabla administrador
CREATE TABLE administrador (
    cedula INT,
    PRIMARY KEY (cedula),
    FOREIGN KEY (cedula) REFERENCES persona(cedula)
);

-- Crear tabla producto
CREATE TABLE producto (
    id_producto INT NOT NULL AUTO_INCREMENT,
    precio SMALLINT,
    nombre VARCHAR(50),
    talle VARCHAR(5),
    cantidad SMALLINT,
    descripcion VARCHAR(1000),
    imagen_url VARCHAR(255),
    estado_producto BOOLEAN,
    modalidad ENUM('Alquiler', 'Compra'),
    categoria ENUM('Trajes', 'Vestidos', 'Accesorios'),
    PRIMARY KEY (id_producto)
);

-- Crear tabla alquiler
CREATE TABLE alquiler (
    id_alquiler INT NOT NULL AUTO_INCREMENT,
    fecha_retiro DATE,
    fecha_devolucion DATE,
    id_producto INT,
    cedula INT,
    PRIMARY KEY (id_alquiler, id_producto),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    FOREIGN KEY (cedula) REFERENCES cliente(cedula)
);

-- Crear tabla compra
CREATE TABLE compra (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    cedula INT NOT NULL,
    fecha_compra DATETIME NOT NULL,
    total INT NOT NULL,
    FOREIGN KEY (cedula) REFERENCES cliente(cedula)
);

-- Crear tabla compra_detalles
CREATE TABLE compra_detalles (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario INT NOT NULL,
    subtotal INT NOT NULL,
    FOREIGN KEY (id_compra) REFERENCES compra(id_compra)
);

-- Agregar un usuario administrador con contraseña simple
INSERT INTO persona (nombre, apellido, cedula, email, telefono, direccion, fecha_nacimiento, contrasena, estado_persona, estado_admin)
VALUES ('Agustín', 'Cantero', 12345678, 'agustincantero@gmail.com', '098765432', '18 de Julio 500', '2000-01-01', MD5('12345678'), 1, 1);

-- Agregar a la tabla administrador
INSERT INTO administrador (cedula)
VALUES (12345678);

-- Agregar un usuario genérico en la tabla persona
INSERT INTO persona (nombre, apellido, cedula, email, telefono, direccion, fecha_nacimiento, contrasena, estado_persona, estado_admin)
VALUES ('Ana', 'Gómez', 87654321, 'anagomez@gmail.com', '091234567', 'Manuel Oribe 456', '1995-05-15', MD5('87654321'), 1, 0);

-- Agregar a la tabla cliente
INSERT INTO cliente (cedula)
VALUES (87654321);

-- Inserción de catalogo de Vestidos 
INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (6, 4950, 'Vestido Blanco Luli', 'XL', 10, '¡Da rienda suelta a tu elegancia interior con el vestido The Pearl! Este impresionante vestido largo presenta un diseño sin mangas, escote cuadrado y delicados tirantes con perlas. Perfecto para destacar en cualquier evento, su diseño atemporal te hará sentir segura y con estilo. ¡Haz que cada paso sea glamoroso con el vestido The Pearl!', 'vestido_blanco.jpg', 1, 'Compra', 'Vestidos');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (5, 3550, 'Vestido Luli Azul', 'S', 10, 'Presentamos el vestido Luli, una obra maestra de elegancia y sofisticación. Este vestido largo fruncido con un solo hombro rezuma lujo y exclusividad. Su diseño es elegante y atemporal, lo que lo convierte en el complemento perfecto para cualquier guardarropa. Saca a relucir tu gracia y estilo interior con el vestido Luli.', 'vestido_azul.jpg', 1, 'Compra', 'Vestidos');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (4, 1250, 'Vestido Rosa Serena', 'S', 10, '¡El vestido Serena es perfecto para cualquier ocasión especial! Este vestido midi rosa intenso presenta un detalle de cinta en un hombro, telas de encaje y un escote de encaje festoneado para darle un toque adicional de elegancia. El forro garantiza un ajuste cómodo y al mismo tiempo marca la diferencia. ¡Siéntete y luce lo mejor posible con el vestido Serena!', 'vestido_rosa.jpg', 1, 'Alquiler', 'Vestidos');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (3, 1500, 'Vestido Nani Fucsia', 'L', 10, 'El vestido Nani Dress Fucsia es una prenda elegante y sofisticada que te hará sentir hermosa y segura. Está confeccionado con un tejido de alta calidad que es suave al tacto y se adapta perfectamente a tu cuerpo. El diseño del vestido es muy favorecedor, con un corte que acentúa la cintura y una falda fluida que cae con gracia. El color fucsia es vibrante y llamativo, y es perfecto para cualquier ocasión especial.', 'vestido_fucsia.jpg', 1, 'Alquiler', 'Vestidos');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (2, 3150, 'Vestido Courtney Negro', 'M', 10, 'Elegante y sofisticado, este vestido Courtney negro es la elección perfecta para cualquier ocasión especial. Confeccionado en un tejido de alta calidad, este vestido presenta un corte favorecedor que acentúa la figura femenina. El color negro intenso añade un toque de misterio y elegancia a cualquier look.', 'vestido_negro.jpg', 1, 'Compra', 'Vestidos');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (1, 3150, 'Vestido Courtney Rojo', 'S', 10, 'Elegante y sofisticado, este vestido Courtney rojo es la elección perfecta para cualquier ocasión especial. Confeccionado en un tejido de alta calidad, este vestido presenta un corte favorecedor que acentúa la figura femenina. El color rojo intenso añade un toque de audacia y sofisticación a cualquier look.','vestido_rojo.jpg', 1, 'Compra', 'Vestidos');

-- Inserción de catalogo de Trajes
INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (12, 1050, 'Traje Gris', 'XL', 10, 'Sutil y elegante, el traje gris claro para hombre define un estilo elegante. Hemos creado un tono icónico de trajes de hombre gris claro, excepcionalmente elevado con un color y un tejido visiblemente texturizados. Compuesto por nuestro tejido Eco Stretch característico, la comodidad y el movimiento son clave en Elite y ultra ponible entre los trajes grises claros para hombre, Textured Grey está compuesto por nuestro tejido Eco Stretch característico, lo que hace que la comodidad y el movimiento sean clave. De tonos suaves y perfecto para cualquier combinación de colores, este traje se puede transformar del día a la noche, del trabajo a una ocasión especial y de un atuendo informal a un atuendo formal abotonado.', 'traje_gris.jpg', 1, 'Alquiler', 'Trajes');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (11, 8590, 'Smoking Negro Clásico', 'S', 10, 'Llevamos el clásico de corbata negra al siguiente nivel. El interés y los detalles añadidos combinados con la innovadora tela Eco Stretch hacen que el esmoquin negro con solapa de pico sea un punto culminante en el estilo formal. El aspecto tradicional y elegante del esmoquin se mantiene intacto, pero la forma audaz de la solapa le da un toque moderno a la chaqueta de solapa de pico del esmoquin negro, y el cómodo tejido Eco Stretch te permite sentirte a gusto con tu estilo formal. Los detalles de satén en la solapa, el forro de los bolsillos, los botones cubiertos y la cinturilla completan el aspecto del esmoquin negro con solapa de pico, lo que lo convierte en un elemento perfecto para una boda y un evento espectacular.', 'smoking_negro.jpg', 1, 'Compra', 'Trajes');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (10, 7990, 'Traje Bordó', 'M', 10, 'El traje burdeos para hombre está aquí para ayudarte a destacar entre la multitud en tu próximo evento. Un color rojo oscuro y matizado es el traje burdeos perfecto. Nuestro traje burdeos para hombre es una opción audaz que sigue anclada firmemente en lo clásico y elegante. Desde pistas de baile de bodas hasta reuniones de negocios y más allá, este conjunto de chaqueta y pantalón burdeos está confeccionado con una tela lujosa y elástica que te permite lucir elegante y sentirte cómodo sin importar lo que pase.', 'traje_bordo.jpg', 1, 'Compra', 'Trajes');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (9, 1175, 'Traje Canela', 'L', 10, 'Encarne la elegancia relajada con este traje de color tostado claro. Este moderno tono arena con textura tejida visible en toda su extensión está diseñado para adaptarse a usted, ya sea para celebraciones soleadas o para la oficina, cenas a la luz de las velas o para cualquier ocasión. El traje de color tostado para hombre está confeccionado con el exclusivo tejido Eco Stretch, que lo mantendrá fresco y cómodo en todo momento. De todos los trajes de color tostado para hombre, este es el nuevo y más novedoso traje de estilo neutro para uso diario, clásico para climas cálidos o para bodas de color tostado.', 'traje_canela.jpg', 1, 'Alquiler', 'Trajes');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (8, 1500, 'Traje Marrón', 'L', 10, 'Descubre un elegante traje marrón, confeccionado en una suave mezcla de lana que combina comodidad y estilo. Su corte ajustado resalta la figura, mientras que el saco con solapas en pico y pantalones de corte recto ofrecen un look clásico y moderno. Ideal para el trabajo o eventos especiales, este traje se adapta perfectamente a una camisa blanca para un estilo profesional o a una camiseta para un toque casual. Con un color marrón que irradia calidez y confianza, ¡es la elección perfecta para destacar en cualquier ocasión!', 'traje_marron.jpg', 1, 'Alquiler', 'Trajes');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (7, 7150, 'Traje Azul Marino', 'M', 10, '¿Buscas la mejor prenda de tu armario? El traje azul marino para hombre es la solución. Nuestro azul marino es un traje azul oscuro que es a la vez saturado y sutil, perfecto para cualquier ocasión y para el día a día. Fabricado con un tejido suave y flexible, este es el traje azul marino para hombre, que se centra en la comodidad. Este traje azul marino es el estilo ideal para bodas y mucho más: un clásico neutro que puede ser romántico o elegante, formal o relajado, y siempre versátil. Diseñado para ser un look elegante al aire libre, atemporal para usar en el interior de un lugar y poderoso para la oficina, el azul marino es el traje azul oscuro adecuado para todo.','traje_marino.jpg', 1, 'Compra', 'Trajes');

-- Inserción de catalogo de Accesorios
INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (24, 790, 'Chaleco Negro Clásico', 'UNICO', 10, 'Completa tu look de 3 piezas con nuestro chaleco negro clásico. ¡Es tan versátil que lo puedes combinar con nuestro traje o esmoquin negro clásico para lograr un look elegante!', 'chaleco_negro.jpg', 1, 'Alquiler', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (25, 790, 'Tirantes Azul Marino', 'UNICO', 10, 'Estos tirantes lisos de grogrén azul marino, un favorito para bodas, son la opción perfecta para tu gran día. Su calidad y asequibilidad los convierten en un artículo imprescindible y le dan ese aspecto más elegante cuando te quitas la chaqueta. Tienen una parte posterior elástica negra con una construcción en forma de "Y".', 'tirantes_azules.jpg', 1, 'Compra', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (26, 820, 'Tirantes Clásicos', 'UNICO', 10, 'Estos tirantes negros sencillos son ideales si buscas versatilidad y un estilo clásico y atemporal. Están confeccionados íntegramente en materiales negros y presentan detalles de cuero negro. Su tono monocromático los hace versátiles, mientras que la opción de clip los hace fáciles de usar.', 'tirantes_negros.jpg', 1, 'Compra', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (13, 650, 'Cinto de Cuero', 'UNICO', 10, '¡Nuestro clásico cinturón color canela es un artículo esencial en cualquier armario! Está fabricado 100 % en cuero, tiene trabillas dobles a juego y hebilla de níquel cepillado. Este cinturón está diseñado para durar y luce increíble combinado con cualquiera de nuestros trajes clásicos y zapatos Theo Tan para completar el look.','cinto_cuero.jpg', 1, 'Compra', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (14, 12500, 'Reloj Casio ECBS100D-1A', 'UNICO', 10, 'Si la velocidad y la precisión son lo tuyo, ponte el dinámico ECBS100D-1A, la belleza de alta tecnología de un reloj, con todo el brillo y el detalle de un auto deportivo de alta gama. Presentamos un reloj de combinación analógico-digital con Smartphone Link y tecnología solar excepcional, todo en un diseño delgado. La esfera de malla metálica negra evoca la parrilla delantera de un auto deportivo para proyectar pura velocidad deportiva. ', 'casio.jpeg', 1, 'Compra', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (15, 1990, 'Zapatos de Charol', 'UNICO', 10, 'No puedes equivocarte con este zapato de esmoquin de piel 100 % patentada de primera calidad. Diseñado para durar y lo suficientemente clásico para durar toda la vida.', 'zapatos.jpg', 1, 'Compra', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (20, 8590, 'Bolso Prada Moon', 'UNICO', 10, 'Inspirado en los archivos de Prada de los años 2000, este bolso de piel acolchado Moon combina elementos tradicionales y los reinterpreta de una forma nueva con un diseño innovador y suave. Fíjate en el acolchado ligero, la correa de piel ajustable y desmontable, el llavero de piel extraíble, el logotipo triangular de metal esmaltado en la correa, el cierre magnético y el forro de piel de napa con bolsillo con cremallera.', 'bolso_prada.jpg', 1, 'Compra', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (21, 7250, 'Diadema Satén Prada', 'UNICO', 10, 'Una lluvia de cristales tonales añade un toque deslumbrante a esta refinada y redondeada diadema de satén brillante.', 'diadema.jpg', 1, 'Compra', 'Accesorios');

INSERT INTO producto (id_producto, precio, nombre, talle, cantidad, descripcion, imagen_url, estado_producto, modalidad, categoria)
VALUES (19, 7990, 'Anillo Prada Symbole', 'UNICO', 10, 'Icónico y elegante, el logo triangular es el protagonista de una nueva línea de joyas elaboradas en plata de ley 925 que reinterpreta las influencias punk de una manera moderna. El símbolo histórico de Prada con acabado esmaltado define este anillo con un diseño refinado.', 'anillo_prada.jpg', 1, 'Compra', 'Accesorios');