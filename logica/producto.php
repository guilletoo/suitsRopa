<?php

class Producto {
    private $id_producto, $nombre, $precio, $talle, $cantidad, $descripcion, $imagen_url, $estado_producto, $modalidad_producto, $categoria_producto;

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getTalle() {
        return $this->talle;
    }

    public function setTalle($talle) {
        $this->talle = $talle;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getImagenUrl() {
        return $this->imagen_url;
    }

    public function setImagenUrl($imagen_url) {
        $this->imagen_url = $imagen_url;
    }

    public function getEstadoProducto() {
        return $this->estado_producto;
    }

    public function setEstadoProducto($estado_producto) {
        $this->estado_producto = $estado_producto;
    }

    public function getModalidadProducto() {
        return $this->modalidad_producto;
    }

    public function setModalidadProducto($modalidad_producto) {
        $this->modalidad_producto = $modalidad_producto;
    }

    public function getCategoriaProducto() {
        return $this->categoria_producto;
    }

    public function setCategoriaProducto($categoria_producto) {
        $this->categoria_producto = $categoria_producto;
    }
}
