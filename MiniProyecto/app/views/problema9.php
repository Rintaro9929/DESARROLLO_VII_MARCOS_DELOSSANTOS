<?php
include 'header.php';
require_once '../utils/Navegacion.php';
require_once '../utils/Sanitizador.php';
require_once '../utils/Validador.php';

$resultados = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numero = Sanitizador::limpiarNumero($_POST['numero']);

    if ($numero >= 1 && $numero <= 9) {

        for ($i = 1; $i <= 15; $i++) {
            $resultados[] = "$numero ^ $i = " . pow($numero, $i);
        }

    } else {
        $error = 'Ingrese un número entre 1 y 9';
    }
}
?>

<div class="container">

    <h2>Problema #9</h2>

    <form method="POST">

        <label>Número:</label>

        <input type="number" name="numero" min="1" max="9" required>

        <button type="submit">Generar</button>

    </form>

    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <?php foreach ($resultados as $resultado): ?>
        <p><?php echo $resultado; ?></p>
    <?php endforeach; ?>

    <?php echo Navegacion::volverMenu('../views/menu.php'); ?>

</div>

<?php include 'footer.php'; ?>