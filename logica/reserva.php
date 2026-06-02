<?php
include_once 'persistencia/persona_bd.php';

class Reserva {
    private $cedula, $fecha_retiro, $fecha_devolucion, $id_producto;

    public function __construct($fecha_retiro, $fecha_devolucion) {
        $this->fecha_retiro = $fecha_retiro;
        $this->fecha_devolucion = $fecha_devolucion;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getFechaRetiro() {
        return $this->fecha_retiro;
    }

    public function setFechaRetiro($fecha_retiro) {
        $this->fecha_retiro = $fecha_retiro;
    }

    public function getFechaDevolucion() {
        return $this->fecha_devolucion;
    }

    public function setFechaDevolucion($fecha_devolucion) {
        $this->fecha_devolucion = $fecha_devolucion;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }

    public function reservar() {
        $reserva = new PersonaBD();
        return $reserva->reservar($this);
    }
}
