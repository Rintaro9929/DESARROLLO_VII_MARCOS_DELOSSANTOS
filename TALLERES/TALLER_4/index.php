<?php
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Empresa.php';

$empresa = new Empresa("TechSolutions Inc.");

$gerente1 = new Gerente("Ana García", 101, 5000, "Desarrollo");
$gerente2 = new Gerente("Carlos López", 102, 5500, "Ventas");
$desarrollador1 = new Desarrollador("Miguel Torres", 201, 3000, "PHP", "Senior");
$desarrollador2 = new Desarrollador("Sofía Martínez", 202, 2500, "JavaScript", "Mid");
$desarrollador3 = new Desarrollador("Javier Ruiz", 203, 2000, "Python", "Junior");

echo "<h2>Agregando empleados:</h2>";
echo "<p>" . $empresa->agregarEmpleado($gerente1) . "</p>";
echo "<p>" . $empresa->agregarEmpleado($gerente2) . "</p>";
echo "<p>" . $empresa->agregarEmpleado($desarrollador1) . "</p>";
echo "<p>" . $empresa->agregarEmpleado($desarrollador2) . "</p>";
echo "<p>" . $empresa->agregarEmpleado($desarrollador3) . "</p>";

echo "<h2>Lista de empleados:</h2>";
$empleados = $empresa->listarEmpleados();
echo "<ul>";
foreach ($empleados as $empleadoInfo) {
    echo "<li>" . $empleadoInfo . "</li>";
}
echo "</ul>";

echo "<h2>Nómina total:</h2>";
$nominaTotal = $empresa->calcularNominaTotal();
echo "<p>La nómina total de la empresa es: $" . number_format($nominaTotal, 2) . "</p>";

echo "<h2>Evaluaciones de desempeño:</h2>";
$evaluaciones = $empresa->realizarEvaluacionesDesempenio();
echo "<ul>";
foreach ($evaluaciones as $evaluacion) {
    echo "<li>" . $evaluacion . "</li>";
}
echo "</ul>";

echo "<h2>Información actualizada después de las evaluaciones:</h2>";
$empleadosActualizados = $empresa->listarEmpleados();
echo "<ul>";
foreach ($empleadosActualizados as $empleadoInfo) {
    echo "<li>" . $empleadoInfo . "</li>";
}
echo "</ul>";

echo "<h2>Nómina total después de las evaluaciones:</h2>";
$nominaTotalActualizada = $empresa->calcularNominaTotal();
echo "<p>La nómina total actualizada de la empresa es: $" . number_format($nominaTotalActualizada, 2) . "</p>";

echo "<h2>Desafíos adicionales:</h2>";

echo "<h3>Empleados por departamento (Desarrollo):</h3>";
$empleadosDesarrollo = $empresa->obtenerEmpleadosPorDepartamento("Desarrollo");
if (count($empleadosDesarrollo) > 0) {
    echo "<ul>";
    foreach ($empleadosDesarrollo as $empleadoInfo) {
        echo "<li>" . $empleadoInfo . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No hay empleados en el departamento de Desarrollo.</p>";
}

echo "<h3>Salario promedio por tipo de empleado:</h3>";
$salariosPromedio = $empresa->calcularSalarioPromedioPorTipo();
foreach ($salariosPromedio as $tipo => $promedio) {
    echo "<p>" . $tipo . ": $" . number_format($promedio, 2) . "</p>";
}

echo "<h3>Guardar y cargar empleados desde archivo:</h3>";
if ($empresa->guardarEmpleados('empleados.json')) {
    echo "<p>Datos de empleados guardados correctamente en empleados.json</p>";
    
    $empresa2 = new Empresa("TechSolutions Backup");
    if ($empresa2->cargarEmpleados('empleados.json')) {
        echo "<p>Datos de empleados cargados correctamente desde empleados.json</p>";
        
        echo "<h4>Empleados cargados desde archivo:</h4>";
        $empleadosCargados = $empresa2->listarEmpleados();
        echo "<ul>";
        foreach ($empleadosCargados as $empleadoInfo) {
            echo "<li>" . $empleadoInfo . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Error al cargar los datos de empleados.</p>";
    }
} else {
    echo "<p>Error al guardar los datos de empleados.</p>";
}
?>