<?php

// Importar archivos
require_once __DIR__ . '/../app/views/header.php';
require_once __DIR__ . '/../app/utils/Navegacion.php';

// Variables
$resultados = [];
$error = "";

// Verificar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener número
    $numero = (int) $_POST['numero'];

    // Validar rango
    if ($numero >= 1 && $numero <= 9) {

        // Generar potencias
        for ($i = 1; $i <= 15; $i++) {

            $resultados[] = "$numero ^ $i = " . pow($numero, $i);
        }

    } else {

        $error = "Ingrese un número entre 1 y 9";
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

    <br>

    <?php

    // Mostrar error
    if ($error) {

        echo "<p>$error</p>";
    }

    // Mostrar resultados
    foreach ($resultados as $resultado) {

        echo "<p>$resultado</p>";
    }

    echo Navegacion::volverMenu('index.php');

    ?>

</div>

<?php require_once __DIR__ . '/../app/views/footer.php'; ?>