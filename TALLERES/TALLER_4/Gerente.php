<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bonus;

    public function __construct($nombre, $id, $salarioBase, $departamento) {
        parent::__construct($nombre, $id, $salarioBase);
        $this->departamento = $departamento;
        $this->bonus = 0;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getBonus() {
        return $this->bonus;
    }

    public function asignarBono($monto) {
        $this->bonus = $monto;
        return "Bono de {$monto} asignado al gerente {$this->getNombre()}";
    }

    public function evaluarDesempenio() {
        $evaluaciones = ["Excelente", "Bueno", "Regular", "Deficiente"];
        $evaluacion = $evaluaciones[array_rand($evaluaciones)];
        
        if ($evaluacion == "Excelente") {
            $this->asignarBono(1000);
        } elseif ($evaluacion == "Bueno") {
            $this->asignarBono(500);
        } else {
            $this->asignarBono(0);
        }
        
        return "Evaluación de desempeño para el gerente {$this->getNombre()}: {$evaluacion}";
    }

    public function calcularSalarioTotal() {
        return $this->getSalarioBase() + $this->bonus;
    }

    public function obtenerInformacion() {
        return parent::obtenerInformacion() . ", Departamento: {$this->departamento}, Bonus: {$this->bonus}, Salario Total: " . $this->calcularSalarioTotal();
    }
}
?>