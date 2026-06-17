<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

$dia = '';
$mes = '';
$anio = '';
$estacion = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dia = (int) $_POST['dia'];
    $mes = (int) $_POST['mes'];
    $anio = (int) $_POST['anio'];

    $estacion = Utilidades::obtenerEstacion($mes);
}

?>

<div class="container">

    <h2>Problema #7</h2>

    <form method="POST">

        <label for="dia">Día:</label>
        <input
            type="number"
            id="dia"
            name="dia"
            min="1"
            max="31"
            required
        >

        <br><br>

        <label for="mes">Mes:</label>
        <input
            type="number"
            id="mes"
            name="mes"
            min="1"
            max="12"
            required
        >

        <br><br>

        <label for="anio">Año:</label>
        <input
            type="number"
            id="anio"
            name="anio"
            min="1900"
            required
        >

        <br><br>

        <button type="submit">
            Determinar estación
        </button>

    </form>

    <?php if (!empty($estacion)) : ?>

        <hr>

        <p>
            <strong>Fecha ingresada:</strong>
            <?php echo "$dia/$mes/$anio"; ?>
        </p>

        <p>
            <strong>Estación del año:</strong>
            <?php echo htmlspecialchars($estacion); ?>
        </p>

    <?php endif; ?>

    <br>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>