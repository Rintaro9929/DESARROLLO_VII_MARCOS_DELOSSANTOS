<?php

// Cargar archivos necesarios
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Utilidades.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';
require_once __DIR__ . '/../app/utils/Sanitizador.php';
require_once __DIR__ . '/../logs/ErrorLogger.php';

// Variables
$resultados = [];
$error = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        // Obtener número
        $numero = Sanitizador::limpiarNumero($_POST['numero']);

        // Validar rango permitido
        if ($numero === false || $numero < 1 || $numero > 9) {

            throw new Exception(
                'Debe ingresar un número entre 1 y 9.'
            );
        }

        // Generar potencias
        $resultados = Utilidades::generarPotencias(
            $numero,
            15
        );

    } catch (Exception $e) {

        // Registrar error
        $logger = new ErrorLogger();

        $logger->registrarError(
            $e->getMessage()
        );

        $error = $e->getMessage();
    }
}

?>

<div class="container">

    <h2>Problema #9</h2>

    <form method="POST">

        <label for="numero">Número:</label>

        <input
            type="number"
            id="numero"
            name="numero"
            min="1"
            max="9"
            required
        >

        <button type="submit">Generar</button>

    </form>

    <br>

    <?php if (!empty($error)) : ?>

        <div class="error">

            <?php echo htmlspecialchars($error); ?>

        </div>

    <?php endif; ?>

    <?php foreach ($resultados as $resultado) : ?>

        <p>

            <?php echo htmlspecialchars($resultado); ?>

        </p>

    <?php endforeach; ?>

    <?php echo Navegacion::volverMenu('index.php'); ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>