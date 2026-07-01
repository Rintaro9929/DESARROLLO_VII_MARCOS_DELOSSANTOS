<?php

require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

$notas = [];
$promedio = 0;
$desviacion = 0;
$minimo = 0;
$maximo = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $notas[] = (float) $_POST['nota1'];
    $notas[] = (float) $_POST['nota2'];
    $notas[] = (float) $_POST['nota3'];

    $promedio = Utilidades::calcularPromedio($notas);
    $desviacion = Utilidades::calcularDesviacion($notas);
    $minimo = Utilidades::obtenerMinimo($notas);
    $maximo = Utilidades::obtenerMaximo($notas);
}

?>

<div class="container">

    <h2>Problema #3</h2>

    <form method="POST">

        <label>Nota 1:</label>
        <input type="number" name="nota1" min="0" max="100" required>

        <br><br>

        <label>Nota 2:</label>
        <input type="number" name="nota2" min="0" max="100" required>

        <br><br>

        <label>Nota 3:</label>
        <input type="number" name="nota3" min="0" max="100" required>

        <br><br>

        <button type="submit">
            Calcular
        </button>

    </form>

    <?php if (!empty($notas)) : ?>

        <hr>

        <p>
            <strong>Notas:</strong>
            <?php echo implode(', ', $notas); ?>
        </p>

        <p>
            <strong>Promedio:</strong>
            <?php echo number_format($promedio, 2); ?>
        </p>

        <p>
            <strong>Desviación estándar:</strong>
            <?php echo number_format($desviacion, 2); ?>
        </p>

        <p>
            <strong>Nota mínima:</strong>
            <?php echo $minimo; ?>
        </p>

        <p>
            <strong>Nota máxima:</strong>
            <?php echo $maximo; ?>
        </p>

    <?php endif; ?>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>