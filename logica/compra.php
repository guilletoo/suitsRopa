<?php
include_once 'persistencia/persona_bd.php';
date_default_timezone_set('America/Montevideo');

class Compra {
    private $cedula;
    private $fecha_compra;
    private $total;
    private $productos; // Array para almacenar los detalles de los productos

    public function __construct($cedula, $productos) {
        $this->cedula = $cedula;
        $this->fecha_compra = date('Y-m-d H:i:s'); // Establece la fecha de compra al momento de instanciar
        $this->productos = $productos; // Array de productos [id_producto => ['cantidad' => cantidad, 'precio' => precio]]
        $this->calcularTotal(); // Calcula el total al momento de crear la compra
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getFechaCompra() {
        return $this->fecha_compra;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getProductos() {
        return $this->productos;
    }

    private function calcularTotal() {
        $this->total = 0;
        foreach ($this->productos as $detalles) {
            $this->total += $detalles['precio'] * $detalles['cantidad'];
        }
    }

    public function comprar() {
        $compraBD = new PersonaBD();
        return $compraBD->comprar($this);
    }
}
