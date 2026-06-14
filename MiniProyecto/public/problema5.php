<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Arreglo de edades
$edades = [10, 15, 25, 70, 8];

?>

<div class="container">

    <h2>Problema #5</h2>

    <?php foreach ($edades as $edad) : ?>

        <p>

            <?php echo $edad; ?> años =
            <?php echo Utilidades::clasificarEdad($edad); ?>

        </p>

    <?php endforeach; ?>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>