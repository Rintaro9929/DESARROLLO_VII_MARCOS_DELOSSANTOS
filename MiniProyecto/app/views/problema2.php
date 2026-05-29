<?php
include 'header.php';
require_once '../utils/Navegacion.php';

$resultados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = (int) $_POST['numero'];

    for ($i = 1; $i <= $numero; $i++) {
        $resultados[] = "4 x $i = " . (4 * $i);
    }
}
?>

<form method="POST">
    <label>Cantidad:</label>
    <input type="number" name="numero" required>
    <button type="submit">Calcular</button>
</form>

<?php
foreach ($resultados as $resultado) {
    echo "<p>$resultado</p>";
}

 echo Navegacion::volverMenu('../views/menu.php');
include 'footer.php';
?>