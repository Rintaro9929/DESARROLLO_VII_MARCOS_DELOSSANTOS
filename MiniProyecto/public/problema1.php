<?php

/*
|--------------------------------------------------------------------------
| Problema #1
|--------------------------------------------------------------------------
| Suma de números del 1 al 1000
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';

/*
|--------------------------------------------------------------------------
| Calcular suma utilizando método reutilizable
|--------------------------------------------------------------------------
*/

$suma = Utilidades::sumarRango(1, 1000);

?>

<div class="container">

    <h2>Problema #1</h2>

    <p>La suma de los números del 1 al 1000 es:</p>

    <h3><?= $suma; ?></h3>

    <?= Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>