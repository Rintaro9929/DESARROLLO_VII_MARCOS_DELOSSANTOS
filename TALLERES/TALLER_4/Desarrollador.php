<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Desarrollador extends Empleado implements Evaluable {
    private $lenguaje;
    private $nivelExperiencia;

    public function __construct($nombre, $id, $salarioBase, $lenguaje, $nivelExperiencia) {
        parent::__construct($nombre, $id, $salarioBase);
        $this->lenguaje = $lenguaje;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    public function getLenguaje() {
        return $this->lenguaje;
    }

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    public function setNivelExperiencia($nivelExperiencia) {
        $this->nivelExperiencia = $nivelExperiencia;
    }

    public function evaluarDesempenio() {
        $evaluaciones = ["Excelente", "Bueno", "Regular", "Deficiente"];
        $evaluacion = $evaluaciones[array_rand($evaluaciones)];
        
        if ($evaluacion == "Excelente") {
            $nuevoSalario = $this->getSalarioBase() * 1.1;
            $this->setSalarioBase($nuevoSalario);
        } elseif ($evaluacion == "Bueno") {
            $nuevoSalario = $this->getSalarioBase() * 1.05;
            $this->setSalarioBase($nuevoSalario);
        }
        
        return "Evaluación de desempeño para el desarrollador {$this->getNombre()}: {$evaluacion}";
    }

    public function obtenerInformacion() {
        return parent::obtenerInformacion() . ", Lenguaje: {$this->lenguaje}, Nivel: {$this->nivelExperiencia}";
    }
}
?>