<?php

// Cargar archivos necesarios
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

    <p><strong>Notas:</strong>
        <?php echo implode(', ', $notas); ?>
    </p>

    <p><strong>Promedio:</strong>
        <?php echo number_format($promedio, 2); ?>
    </p>

    <p><strong>Desviación estándar:</strong>
        <?php echo number_format($desviacion, 2); ?>
    </p>

    <p><strong>Nota mínima:</strong>
        <?php echo $minimo; ?>
    </p>

    <p><strong>Nota máxima:</strong>
        <?php echo $maximo; ?>
    </p>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>