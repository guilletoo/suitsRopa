<?php
class Conexion {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "suits";
    private $conexion;

    public function conectar() {
        $this->conexion = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        } else {
            return $this->conexion;
        }
    }

    public function desconectar() {
        $this->conexion->close();
    }
}
