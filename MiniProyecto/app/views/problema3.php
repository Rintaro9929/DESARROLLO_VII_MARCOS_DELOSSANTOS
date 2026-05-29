<?php
include 'header.php';
require_once '../utils/Utilidades.php';
require_once '../utils/Navegacion.php';

$notas = [90, 85, 70, 100, 95];

$promedio = Utilidades::calcularPromedio($notas);
$desviacion = Utilidades::calcularDesviacion($notas);
$minimo = Utilidades::obtenerMinimo($notas);
$maximo = Utilidades::obtenerMaximo($notas);
?>

<h2>Problema #3</h2>

<p>Promedio: <?php echo $promedio; ?></p>
<p>Desviación: <?php echo $desviacion; ?></p>
<p>Mínimo: <?php echo $minimo; ?></p>
<p>Máximo: <?php echo $maximo; ?></p>

<?php
 echo Navegacion::volverMenu('../views/menu.php');
include 'footer.php';
?>