<?php
include_once "persistencia/admin_bd.php";
include_once "persona.php";
include_once "producto.php";

class Admin extends Persona {

    private $cedula;

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function agregarAdmin() {
        $admin = new AdminBD();
        return $admin->agregarAdmin($this->cedula);
    }

    public function eliminarAdmin() {
        $admin = new AdminBD();
        return $admin->eliminarAdmin($this->cedula);
    }

    public function cargarProducto(Producto $producto) {
        $adminBD = new AdminBD();

        $adminBD->cargarProductos(
            $producto->getNombre(),
            $producto->getPrecio(),
            $producto->getTalle(),
            $producto->getCantidad(),
            $producto->getDescripcion(),
            $producto->getImagenUrl(),
            $producto->getModalidadProducto(),
            $producto->getCategoriaProducto()
        );
    }

    public function modificarProducto(Producto $producto) {

        $admin = new AdminBD();
        return $admin->modificarProducto(
            $producto->getIdProducto(),
            $producto->getNombre(),
            $producto->getPrecio(),
            $producto->getTalle(),
            $producto->getCantidad(),
            $producto->getDescripcion(),
            $producto->getImagenUrl(),
            $producto->getCategoriaProducto()
        );
    }

    public function listarProducto() {
        $l = new AdminBD();
        return $l->listarProductos();
    }


    public function listarProductoActivo() {
        $l = new AdminBD();
        return $l->listarProductosActivos();
    }

    public function listarAdministradores() {
        $adminBD = new AdminBD();
        return $adminBD->listarAdministradores();
    }
}
