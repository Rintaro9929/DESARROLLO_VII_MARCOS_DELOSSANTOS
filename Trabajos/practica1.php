<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Operaciones Básicas en PHP</title>
</head>
<body>

<h2>Operaciones Básicas</h2>

<form method="post">
    Número 1: <input type="number" name="num1" required><br><br>
    Número 2: <input type="number" name="num2" required><br><br>
    <input type="submit" value="Calcular">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $numero1 = $_POST["num1"];
    $numero2 = $_POST["num2"];

    // 1. Suma
    $suma = $numero1 + $numero2;

    // 2. Resta
    $resta = $numero1 - $numero2;

    // 3. Multiplicación
    $multiplicacion = $numero1 * $numero2;

    echo "<h3>Valores ingresados:</h3>";
    echo "Número 1: $numero1 <br>";
    echo "Número 2: $numero2 <br><br>";

    echo "<h3>Resultados:</h3>";
    echo "Suma: $suma <br>";
    echo "Resta: $resta <br>";
    echo "Multiplicación: $multiplicacion <br><br>";

    // 4. Ejemplo de precedencia
    $resultado1 = 2 + 3 * 4;
    $resultado2 = (2 + 3) * 4;

    echo "<h3>Orden de Precedencia:</h3>";
    echo "2 + 3 * 4 = $resultado1 <br>";
    echo "(2 + 3) * 4 = $resultado2 <br>";
}
?>

</body>
</html>