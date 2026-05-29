<?php

// Importar archivos reutilizables
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Arreglo para guardar resultados
$resultados = [];

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener número
    $numero = (int) $_POST['numero'];

    // Generar múltiplos
    for ($i = 1; $i <= $numero; $i++) {

        $resultados[] = "4 x $i = " . (4 * $i);
    }
}

?>

<div class="container">

    <h2>Problema #2</h2>

    <form method="POST">

        <label>Cantidad:</label>

        <input type="number" name="numero" required>

        <button type="submit">Calcular</button>

    </form>

    <br>

    <?php

    // Mostrar resultados
    foreach ($resultados as $resultado) {

        echo "<p>$resultado</p>";
    }

    // Botón volver
    echo Navegacion::volverMenu('index.php');

    ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>