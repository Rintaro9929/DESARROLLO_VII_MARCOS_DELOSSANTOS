<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';
require_once __DIR__ . '/../app/utils/Sanitizador.php';
require_once __DIR__ . '/../app/utils/ErrorLogger.php';

// Variables
$resultados = [];
$error = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        // Obtener y validar número
        $numero = Sanitizador::limpiarNumero($_POST['numero']);

        if ($numero === false || $numero <= 0) {
            throw new Exception(
                'Debe ingresar un número entero mayor que cero.'
            );
        }

        // Generar múltiplos de 4
        for ($i = 1; $i <= $numero; $i++) {

            $resultados[] = "4 x $i = " . (4 * $i);
        }

    } catch (Exception $e) {

        // Registrar error
        $logger = new ErrorLogger();
        $logger->registrarError($e->getMessage());

        $error = $e->getMessage();
    }
}

?>

<div class="container">

    <h2>Problema #2</h2>

    <p>Mostrar los múltiplos de 4 hasta la cantidad indicada.</p>

    <form method="POST">

        <label for="numero">Cantidad:</label>

        <input
            type="number"
            id="numero"
            name="numero"
            min="1"
            required
        >

        <button type="submit">Calcular</button>

    </form>

    <br>

    <?php if (!empty($error)) : ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <?php if (!empty($resultados)) : ?>

        <h3>Resultados</h3>

        <?php foreach ($resultados as $resultado) : ?>

            <p><?php echo htmlspecialchars($resultado); ?></p>

        <?php endforeach; ?>

    <?php endif; ?>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>