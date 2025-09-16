<?php
class Empleado {
    protected $nombre;
    protected $id;
    protected $salarioBase;

    public function __construct($nombre, $id, $salarioBase) {
        $this->nombre = $nombre;
        $this->id = $id;
        $this->salarioBase = $salarioBase;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getSalarioBase() {
        return $this->salarioBase;
    }

    public function setSalarioBase($salarioBase) {
        $this->salarioBase = $salarioBase;
    }

    public function obtenerInformacion() {
        return "ID: {$this->id}, Nombre: {$this->nombre}, Salario Base: {$this->salarioBase}";
    }
}
?>