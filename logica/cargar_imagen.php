<?php

function cargarImagen(): mixed {

    if (isset($_FILES['imagen_url'])) {

        // Verifica si hay un error en la carga
        if ($_FILES['imagen_url']['error'] !== UPLOAD_ERR_OK) {
            echo "Error en la carga del archivo: " . $_FILES['image']['error'];
            return null;
        }

        // Obtener detalles del archivo
        $ruta_temporal = $_FILES['imagen_url']['tmp_name'];
        $nombre_del_archivo = $_FILES['imagen_url']['name'];
        $nombre_del_archivo_cmps = explode(".", $nombre_del_archivo);
        $extension_del_archivo = strtolower(end($nombre_del_archivo_cmps));

        // Definir extensiones permitidas
        $extensiones_permitidas = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($extension_del_archivo, $extensiones_permitidas)) {
            $directorio_destino = 'assets/img/productos/';
            $ruta_competa_final = $directorio_destino . $nombre_del_archivo;

            // Verifica si el archivo es realmente una imagen
            if (getimagesize($ruta_temporal) === false) {
                echo "El archivo no es una imagen.";
                return null;
            }

            // Mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($ruta_temporal, $ruta_competa_final)) {
                echo "<script>console.log('El archivo fue guardado correctamente.');</script>";
                return $nombre_del_archivo;
            } else {
                echo "Hubo un error moviendo el archivo a la carpeta de destino.";
                return null;
            }
        } else {
            echo "Tipo de archivo no permitido. Solo se permiten imágenes en formato JPG, PNG, GIF.";
            return null;
        }
    } else {
        echo "Hubo un error al subir el archivo.";
        return null;
    }
}

function cargarImagen2(): mixed {

    if (isset($_FILES['imagen_url2'])) {

        // Verifica si hay un error en la carga
        if ($_FILES['imagen_url2']['error'] !== UPLOAD_ERR_OK) {
            echo "Error en la carga del archivo: " . $_FILES['image']['error'];
        }

        // Obtener detalles del archivo
        $ruta_temporal = $_FILES['imagen_url2']['tmp_name'];
        $nombre_del_archivo = $_FILES['imagen_url2']['name'];
        $nombre_del_archivo_cmps = explode(".", $nombre_del_archivo);
        $extension_del_archivo = strtolower(end($nombre_del_archivo_cmps));

        // Definir extensiones permitidas
        $extensiones_permitidas = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($extension_del_archivo, $extensiones_permitidas)) {
            $directorio_destino = 'assets/img/productos/';
            $ruta_competa_final = $directorio_destino . $nombre_del_archivo;

            // Verifica si el archivo es realmente una imagen
            if (getimagesize($ruta_temporal) === false) {
                echo "El archivo no es una imagen.";
                return null;
            }

            // Mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($ruta_temporal, $ruta_competa_final)) {
                echo "<script>console.log('El archivo fue guardado correctamente.');</script>";
                return $nombre_del_archivo;
            } else {
                echo "Hubo un error moviendo el archivo a la carpeta de destino.";
                return null;
            }
        } else {
            echo "Tipo de archivo no permitido. Solo se permiten imágenes en formato JPG, PNG, GIF, JPEG.";
            return null;
        }
    } else {
        echo "Hubo un error al subir el archivo.";
        return null;
    }
}
