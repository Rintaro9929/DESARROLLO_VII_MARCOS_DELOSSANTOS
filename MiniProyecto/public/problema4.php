<?php

// Importar archivos
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Variables
$pares = 0;
$impares = 0;

// Recorrer números
for ($i = 1; $i <= 200; $i++) {

    // Verificar si es par
    if ($i % 2 == 0) {

        $pares += $i;

    } else {

        $impares += $i;
    }
}

?>

<div class="container">

    <h2>Problema #4</h2>

    <p>Suma de pares: <?php echo $pares; ?></p>

    <p>Suma de impares: <?php echo $impares; ?></p>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>