<?php

// Importar archivos
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Arreglo de edades
$edades = [10, 15, 25, 70, 8];

?>

<div class="container">

    <h2>Problema #5</h2>

    <?php

    // Recorrer edades
    foreach ($edades as $edad) {

        // Clasificación
        switch (true) {

            case ($edad >= 0 && $edad <= 12):

                echo "<p>$edad años = Niño</p>";

                break;

            case ($edad >= 13 && $edad <= 17):

                echo "<p>$edad años = Adolescente</p>";

                break;

            case ($edad >= 18 && $edad <= 64):

                echo "<p>$edad años = Adulto</p>";

                break;

            default:

                echo "<p>$edad años = Adulto Mayor</p>";
        }
    }

    echo Navegacion::volverMenu('index.php');

    ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>