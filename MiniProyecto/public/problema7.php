<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Mes de ejemplo
$mes = 5;

// Obtener estación
$estacion = Utilidades::obtenerEstacion($mes);

?>

<div class="container">

    <h2>Problema #7</h2>

    <p>
        <strong>Mes seleccionado:</strong>
        <?php echo $mes; ?>
    </p>

    <p>La estación del año es:</p>

    <h3><?php echo $estacion; ?></h3>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>