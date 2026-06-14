<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Número base
$numero = 4;

// Generar potencias
$potencias = Utilidades::generarPotencias($numero, 15);

?>

<div class="container">

    <h2>Problema #8</h2>

    <p>
        <strong>Número base:</strong>
        <?php echo $numero; ?>
    </p>

    <?php foreach ($potencias as $potencia) : ?>

        <p><?php echo $potencia; ?></p>

    <?php endforeach; ?>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>