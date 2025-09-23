<?php
/**
 * Proyecto Final: Sistema de Gestión de Estudiantes
 * Autor: Marcos De Los Santos
 * Archivo: proyecto_final.php
 * Descripción: Implementación de clases y funcionalidades para la gestión de estudiantes.
 */

// Clase Estudiante
class Estudiante
{
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias; // ['materia' => calificacion]
    private array $flags;    // ['en_riesgo', 'honor_roll', etc.]

    public function __construct(int $id, string $nombre, int $edad, string $carrera, array $materias = [])
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = $materias;
        $this->flags = [];
        $this->actualizarFlags();
    }

    public function agregarMateria(string $materia, float $calificacion): void
    {
        if ($calificacion < 0 || $calificacion > 100) {
            throw new InvalidArgumentException("La calificación debe estar entre 0 y 100.");
        }
        $this->materias[$materia] = $calificacion;
        $this->actualizarFlags();
    }

    public function obtenerPromedio(): float
    {
        if (empty($this->materias)) return 0.0;
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => $this->obtenerPromedio(),
            'flags' => $this->flags
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getCarrera(): string
    {
        return $this->carrera;
    }

    public function getMaterias(): array
    {
        return $this->materias;
    }

    public function getFlags(): array
    {
        return $this->flags;
    }

    // Flags: "en riesgo académico" (<60 en alguna materia), "honor roll" (promedio >=90)
    private function actualizarFlags(): void
    {
        $this->flags = [];
        if (count($this->materias) > 0 && min($this->materias) < 60) {
            $this->flags[] = 'en riesgo académico';
        }
        if ($this->obtenerPromedio() >= 90) {
            $this->flags[] = 'honor roll';
        }
    }

    public function __toString(): string
    {
        return "{$this->id} - {$this->nombre} ({$this->carrera}) | Promedio: " . number_format($this->obtenerPromedio(), 2) . " | Flags: " . implode(', ', $this->flags);
    }
}

// Clase SistemaGestionEstudiantes
class SistemaGestionEstudiantes
{
    private array $estudiantes; // [id => Estudiante]
    private array $graduados;   // [id => Estudiante]

    public function __construct()
    {
        $this->estudiantes = [];
        $this->graduados = [];
    }

    public function agregarEstudiante(Estudiante $estudiante): void
    {
        $id = $estudiante->getId();
        if (isset($this->estudiantes[$id]) || isset($this->graduados[$id])) {
            throw new Exception("El estudiante con ID $id ya existe.");
        }
        $this->estudiantes[$id] = $estudiante;
    }

    public function obtenerEstudiante(int $id): ?Estudiante
    {
        return $this->estudiantes[$id] ?? null;
    }

    public function listarEstudiantes(): array
    {
        return array_values($this->estudiantes);
    }

    public function calcularPromedioGeneral(): float
    {
        if (empty($this->estudiantes)) return 0.0;
        $promedios = array_map(fn($e) => $e->obtenerPromedio(), $this->estudiantes);
        return array_sum($promedios) / count($promedios);
    }

    public function obtenerEstudiantesPorCarrera(string $carrera): array
    {
        return array_values(array_filter($this->estudiantes, fn($e) => strcasecmp($e->getCarrera(), $carrera) === 0));
    }

    public function obtenerMejorEstudiante(): ?Estudiante
    {
        if (empty($this->estudiantes)) return null;
        return array_reduce($this->estudiantes, function($mejor, $actual) {
            return ($mejor === null || $actual->obtenerPromedio() > $mejor->obtenerPromedio()) ? $actual : $mejor;
        }, null);
    }

    // Reporte de rendimiento por materia: promedio, máxima y mínima
    public function generarReporteRendimiento(): array
    {
        $materias = [];
        foreach ($this->estudiantes as $est) {
            foreach ($est->getMaterias() as $mat => $calif) {
                $materias[$mat][] = $calif;
            }
        }
        $reporte = [];
        foreach ($materias as $mat => $califs) {
            $reporte[$mat] = [
                'promedio' => count($califs) ? array_sum($califs) / count($califs) : 0,
                'maxima' => count($califs) ? max($califs) : 0,
                'minima' => count($califs) ? min($califs) : 0
            ];
        }
        return $reporte;
    }

    public function graduarEstudiante(int $id): bool
    {
        if (!isset($this->estudiantes[$id])) return false;
        $this->graduados[$id] = $this->estudiantes[$id];
        unset($this->estudiantes[$id]);
        return true;
    }

    public function generarRanking(): array
    {
        $ranking = $this->listarEstudiantes();
        usort($ranking, fn($a, $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $ranking;
    }

    // Búsqueda parcial e insensible a mayúsculas/minúsculas por nombre o carrera
    public function buscarEstudiantes(string $termino): array
    {
        $termino = mb_strtolower($termino);
        return array_values(array_filter($this->estudiantes, function($e) use ($termino) {
            return mb_strpos(mb_strtolower($e->getNombre()), $termino) !== false ||
                   mb_strpos(mb_strtolower($e->getCarrera()), $termino) !== false;
        }));
    }

    // Estadísticas por carrera: número de estudiantes, promedio general, mejor estudiante
    public function generarEstadisticasPorCarrera(): array
    {
        $estadisticas = [];
        $carreras = array_unique(array_map(fn($e) => $e->getCarrera(), $this->estudiantes));
        foreach ($carreras as $carrera) {
            $estCarrera = $this->obtenerEstudiantesPorCarrera($carrera);
            $num = count($estCarrera);
            $prom = $num ? array_sum(array_map(fn($e) => $e->obtenerPromedio(), $estCarrera)) / $num : 0;
            $mejor = $num ? array_reduce($estCarrera, function($mejor, $actual) {
                return ($mejor === null || $actual->obtenerPromedio() > $mejor->obtenerPromedio()) ? $actual : $mejor;
            }, null) : null;
            $estadisticas[$carrera] = [
                'num_estudiantes' => $num,
                'promedio_general' => $prom,
                'mejor_estudiante' => $mejor ? $mejor->getNombre() : null
            ];
        }
        return $estadisticas;
    }

    public function listarGraduados(): array
    {
        return array_values($this->graduados);
    }
}

// Sección de pruebas
$sistema = new SistemaGestionEstudiantes();

// Crear 10 estudiantes con diferentes carreras, edades y calificaciones
$datosEstudiantes = [
    [1, 'Ana López', 20, 'Ingeniería', ['Matemáticas'=>95, 'Física'=>88, 'Química'=>92]],
    [2, 'Carlos Pérez', 22, 'Medicina', ['Biología'=>78, 'Química'=>85, 'Anatomía'=>90]],
    [3, 'María Gómez', 19, 'Derecho', ['Historia'=>80, 'Derecho Civil'=>70, 'Derecho Penal'=>65]],
    [4, 'Luis Torres', 21, 'Ingeniería', ['Matemáticas'=>55, 'Física'=>60, 'Programación'=>58]],
    [5, 'Sofía Ramírez', 23, 'Psicología', ['Psicología'=>92, 'Estadística'=>89, 'Sociología'=>95]],
    [6, 'Pedro Sánchez', 20, 'Medicina', ['Biología'=>60, 'Química'=>62, 'Anatomía'=>58]],
    [7, 'Lucía Fernández', 22, 'Ingeniería', ['Matemáticas'=>100, 'Física'=>98, 'Programación'=>99]],
    [8, 'Jorge Castillo', 24, 'Derecho', ['Historia'=>75, 'Derecho Civil'=>80, 'Derecho Penal'=>85]],
    [9, 'Valentina Ruiz', 21, 'Psicología', ['Psicología'=>55, 'Estadística'=>60, 'Sociología'=>58]],
    [10, 'Miguel Herrera', 20, 'Ingeniería', ['Matemáticas'=>85, 'Física'=>80, 'Programación'=>90]],

// Instanciar y agregar estudiantes
foreach ($datosEstudiantes as [$id, $nombre, $edad, $carrera, $materias]) {
    $est = new Estudiante($id, $nombre, $edad, $carrera, $materias);
    $sistema->agregarEstudiante($est);
}
];

// Mostrar todos los estudiantes
echo "Listado de estudiantes:\n";
foreach ($sistema->listarEstudiantes() as $est) {
    echo $est . "\n";
}
echo "\n";

// Buscar estudiantes por nombre/carrera (parcial, insensible a mayúsculas)
echo "Búsqueda de 'ingenier':\n";
foreach ($sistema->buscarEstudiantes('ingenier') as $est) {
    echo $est . "\n";
}
echo "\n";

// Promedio general del sistema
echo "Promedio general de todos los estudiantes: " . number_format($sistema->calcularPromedioGeneral(), 2) . "\n\n";

// Estudiantes por carrera
echo "Estudiantes de Psicología:\n";
foreach ($sistema->obtenerEstudiantesPorCarrera('Psicología') as $est) {
    echo $est . "\n";
}
echo "\n";

// Mejor estudiante
$mejor = $sistema->obtenerMejorEstudiante();
echo "Mejor estudiante: " . ($mejor ? $mejor : "No hay estudiantes") . "\n\n";

// Reporte de rendimiento por materia
echo "Reporte de rendimiento por materia:\n";
foreach ($sistema->generarReporteRendimiento() as $materia => $datos) {
    echo "$materia: Promedio=" . number_format($datos['promedio'],2) . ", Máxima=" . $datos['maxima'] . ", Mínima=" . $datos['minima'] . "\n";
}
echo "\n";

// Graduar estudiante
echo "Graduando estudiante con ID 2...\n";
if ($sistema->graduarEstudiante(2)) {
    echo "Estudiante graduado exitosamente.\n";
} else {
    echo "No se encontró el estudiante para graduar.\n";
}
echo "\n";

// Listar graduados
echo "Listado de graduados:\n";
foreach ($sistema->listarGraduados() as $grad) {
    echo $grad . "\n";
}
echo "\n";

// Ranking de estudiantes
echo "Ranking de estudiantes por promedio:\n";
foreach ($sistema->generarRanking() as $pos => $est) {
    echo ($pos+1) . ". " . $est . "\n";
}
echo "\n";

// Estadísticas por carrera
echo "Estadísticas por carrera:\n";
foreach ($sistema->generarEstadisticasPorCarrera() as $carrera => $stats) {
    echo "$carrera: #Estudiantes={$stats['num_estudiantes']}, Promedio=" . number_format($stats['promedio_general'],2) . ", Mejor={$stats['mejor_estudiante']}\n";
}
echo "\n";

// Ejemplo de manejo de error: buscar estudiante inexistente
$idBuscado = 99;
$est = $sistema->obtenerEstudiante($idBuscado);
echo "Buscar estudiante con ID $idBuscado: " . ($est ? $est : "No encontrado") . "\n";

// Fin del script
?>