<?php
include 'header.php';
require_once '../utils/Navegacion.php';

$suma = 0;

for ($i = 1; $i <= 1000; $i++) {
    $suma += $i;
}
?>

<div class="container">
    <h2>Problema #1</h2>

    <p>La suma del 1 al 1000 es:</p>
    <h3><?php echo $suma; ?></h3>

    <?php echo Navegacion::volverMenu('../views/menu.php'); ?>
</div>

<?php include 'footer.php'; ?>