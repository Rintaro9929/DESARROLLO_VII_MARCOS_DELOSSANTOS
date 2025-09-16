<?php
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Evaluable.php';

class Empresa {
    private $empleados = [];
    private $nombre;

    public function __construct($nombre) {
        $this->nombre = $nombre;
    }

    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
        return "Empleado {$empleado->getNombre()} agregado a la empresa {$this->nombre}";
    }

    public function listarEmpleados() {
        $lista = [];
        foreach ($this->empleados as $empleado) {
            $lista[] = $empleado->obtenerInformacion();
        }
        return $lista;
    }

    public function calcularNominaTotal() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Gerente) {
                $total += $empleado->calcularSalarioTotal();
            } else {
                $total += $empleado->getSalarioBase();
            }
        }
        return $total;
    }

    public function realizarEvaluacionesDesempenio() {
        $resultados = [];
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                $resultados[] = $empleado->evaluarDesempenio();
            }
        }
        return $resultados;
    }

    public function obtenerEmpleadosPorDepartamento($departamento) {
        $empleadosDepartamento = [];
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Gerente && $empleado->getDepartamento() == $departamento) {
                $empleadosDepartamento[] = $empleado->obtenerInformacion();
            }
        }
        return $empleadosDepartamento;
    }

    public function calcularSalarioPromedioPorTipo() {
        $salarios = [
            'Gerente' => ['total' => 0, 'count' => 0],
            'Desarrollador' => ['total' => 0, 'count' => 0]
        ];

        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Gerente) {
                $salarios['Gerente']['total'] += $empleado->calcularSalarioTotal();
                $salarios['Gerente']['count']++;
            } elseif ($empleado instanceof Desarrollador) {
                $salarios['Desarrollador']['total'] += $empleado->getSalarioBase();
                $salarios['Desarrollador']['count']++;
            }
        }

        $promedios = [];
        foreach ($salarios as $tipo => $data) {
            if ($data['count'] > 0) {
                $promedios[$tipo] = $data['total'] / $data['count'];
            } else {
                $promedios[$tipo] = 0;
            }
        }

        return $promedios;
    }

    public function guardarEmpleados($archivo) {
        $datos = [];
        foreach ($this->empleados as $empleado) {
            $datos[] = [
                'tipo' => get_class($empleado),
                'nombre' => $empleado->getNombre(),
                'id' => $empleado->getId(),
                'salarioBase' => $empleado->getSalarioBase(),
                'departamento' => $empleado instanceof Gerente ? $empleado->getDepartamento() : null,
                'lenguaje' => $empleado instanceof Desarrollador ? $empleado->getLenguaje() : null,
                'nivelExperiencia' => $empleado instanceof Desarrollador ? $empleado->getNivelExperiencia() : null
            ];
        }
        
        $json = json_encode($datos, JSON_PRETTY_PRINT);
        return file_put_contents($archivo, $json) !== false;
    }

    public function cargarEmpleados($archivo) {
        if (!file_exists($archivo)) {
            return false;
        }
        
        $json = file_get_contents($archivo);
        $datos = json_decode($json, true);
        
        if ($datos === null) {
            return false;
        }
        
        $this->empleados = [];
        foreach ($datos as $empleadoData) {
            if ($empleadoData['tipo'] == 'Gerente') {
                $empleado = new Gerente(
                    $empleadoData['nombre'],
                    $empleadoData['id'],
                    $empleadoData['salarioBase'],
                    $empleadoData['departamento']
                );
            } elseif ($empleadoData['tipo'] == 'Desarrollador') {
                $empleado = new Desarrollador(
                    $empleadoData['nombre'],
                    $empleadoData['id'],
                    $empleadoData['salarioBase'],
                    $empleadoData['lenguaje'],
                    $empleadoData['nivelExperiencia']
                );
            } else {
                continue;
            }
            
            $this->empleados[] = $empleado;
        }
        
        return true;
    }
}
?>