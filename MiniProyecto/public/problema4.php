<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Calcular resultados
$pares = Utilidades::sumarPares(1, 200);
$impares = Utilidades::sumarImpares(1, 200);

?>

<div class="container">

    <h2>Problema #4</h2>

    <p>
        <strong>Suma de números pares:</strong>
        <?php echo $pares; ?>
    </p>

    <p>
        <strong>Suma de números impares:</strong>
        <?php echo $impares; ?>
    </p>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>