<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Presupuesto total
$presupuesto = 200000;

// Distribuir presupuesto
$areas = Utilidades::distribuirPresupuesto($presupuesto);

?>

<div class="container">

    <h2>Problema #6</h2>

    <p>
        <strong>Presupuesto total:</strong>
        $<?php echo number_format($presupuesto, 2); ?>
    </p>

    <p>
        <strong>Ginecología:</strong>
        $<?php echo number_format($areas['ginecologia'], 2); ?>
    </p>

    <p>
        <strong>Traumatología:</strong>
        $<?php echo number_format($areas['traumatologia'], 2); ?>
    </p>

    <p>
        <strong>Pediatría:</strong>
        $<?php echo number_format($areas['pediatria'], 2); ?>
    </p>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>