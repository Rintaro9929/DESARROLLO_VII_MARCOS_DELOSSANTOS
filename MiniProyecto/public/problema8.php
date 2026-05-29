<?php

// Importar archivos
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Número base
$numero = 4;

?>

<div class="container">

    <h2>Problema #8</h2>

    <?php

    // Generar potencias
    for ($i = 1; $i <= 15; $i++) {

        echo "<p>$numero elevado a $i = " . pow($numero, $i) . "</p>";
    }

    echo Navegacion::volverMenu('index.php');

    ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>