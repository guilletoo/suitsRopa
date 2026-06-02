<?php
include_once 'persistencia/persona_bd.php';
include_once 'producto.php';

class Persona {
    private $cedula, $nombre, $apellido, $fecha_nacimiento, $direccion, $telefono, $contrasena, $estado_persona, $email;

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento($fecha_nacimiento) {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getContrasena() {
        return $this->contrasena;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getEstadoPersona() {
        return $this->estado_persona;
    }

    public function setEstadoPersona($estado_persona) {
        $this->estado_persona = $estado_persona;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function iniciarSesion() {
        $persona = new PersonaBD();
        return $persona->iniciarSesion($this->cedula, $this->contrasena);
    }

    public function registrarse() {
        $persona = new PersonaBD();
        return $persona->registrarse($this->nombre, $this->apellido, $this->cedula, $this->contrasena);
    }

    public function editarPerfil() {
        $persona = new PersonaBD();
        return $persona->editarPerfil($this->cedula, $this->nombre, $this->apellido, $this->email, $this->telefono, $this->direccion, $this->fecha_nacimiento, $this->estado_persona);
    }

    public function completarDatosPersonales() {
        $persona = new PersonaBD();
        return $persona->completarDatosPersonales($this->cedula, $this->nombre, $this->apellido, $this->email, $this->telefono, $this->direccion, $this->estado_persona);
    }

    public function cambiarContrasena($contrasena_actual, $contrasena_nueva) {
        $persona_bd = new PersonaBD();
        $hashed_password = md5($contrasena_actual);
        $es_correcta = $persona_bd->verificarContrasena($this->cedula, $hashed_password);

        if ($es_correcta) {
            $hashed_password2 = md5($contrasena_nueva);

            return $persona_bd->actualizarContrasena($this->cedula, $hashed_password2);
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia',
                        text: 'El teléfono debe ser un número.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
            </script>";
            return false;
        }
    }

    public function darseDeBaja($contrasena) {
        $persona = new PersonaBD();
        $contrasena = md5($contrasena);
        $es_correcta = $persona->verificarContrasena($this->cedula, $contrasena);

        if ($es_correcta) {
            return $persona->cambiarEstadoCuenta($this->cedula, 0); // 0 indica que la cuenta está dada de baja
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La contraseña ingresada es incorrecta.',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                });
            </script>";
        }
    }

    public function obtenerProductoPorId($id_producto) {
        $personaBD = new PersonaBD();
        return $personaBD->obtenerProductoPorId($id_producto);
    }
}
