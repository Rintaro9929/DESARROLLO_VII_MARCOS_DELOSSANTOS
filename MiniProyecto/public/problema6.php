<?php

// Importar archivos
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Presupuesto
$presupuesto = 100000;

// Calcular porcentajes
$ginecologia = $presupuesto * 0.40;

$traumatologia = $presupuesto * 0.35;

$pediatria = $presupuesto * 0.25;

?>

<div class="container">

    <h2>Problema #6</h2>

    <p>Ginecología: $<?php echo $ginecologia; ?></p>

    <p>Traumatología: $<?php echo $traumatologia; ?></p>

    <p>Pediatría: $<?php echo $pediatria; ?></p>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>