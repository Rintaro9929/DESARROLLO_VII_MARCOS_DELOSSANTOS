<?php

// Importar utilidades
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Notas de ejemplo
$notas = [90, 85, 70, 100, 95];

// Calcular estadísticas
$promedio = Utilidades::calcularPromedio($notas);

$desviacion = Utilidades::calcularDesviacion($notas);

$minimo = Utilidades::obtenerMinimo($notas);

$maximo = Utilidades::obtenerMaximo($notas);

?>

<div class="container">

    <h2>Problema #3</h2>

    <p>Promedio: <?php echo $promedio; ?></p>

    <p>Desviación estándar: <?php echo $desviacion; ?></p>

    <p>Nota mínima: <?php echo $minimo; ?></p>

    <p>Nota máxima: <?php echo $maximo; ?></p>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>