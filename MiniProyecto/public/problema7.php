<?php

// Importar archivos
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Mes de ejemplo
$mes = 5;

// Verificar estación
switch ($mes) {

    case 12:
    case 1:
    case 2:

        $estacion = "Invierno";

        break;

    case 3:
    case 4:
    case 5:

        $estacion = "Primavera";

        break;

    case 6:
    case 7:
    case 8:

        $estacion = "Verano";

        break;

    default:

        $estacion = "Otoño";
}

?>

<div class="container">

    <h2>Problema #7</h2>

    <p>La estación del año es:</p>

    <h3><?php echo $estacion; ?></h3>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>