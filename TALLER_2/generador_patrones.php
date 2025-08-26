<?php
// 1. Triángulo rectángulo con asteriscos usando for
echo "<h3>Triángulo rectángulo:</h3>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}

// 2. Números impares del 1 al 20 usando while
echo "<h3>Números impares del 1 al 20:</h3>";
$num = 1;
while ($num <= 20) {
    if ($num % 2 != 0) {
        echo $num . " ";
    }
    $num++;
}
echo "<br>";

// 3. Contador regresivo desde 10 hasta 1, saltando el 5, usando do-while
echo "<h3>Contador regresivo (saltando el 5):</h3>";
$contador = 10;
do {
    if ($contador == 5) {
        $contador--;
        continue;
    }
    echo $contador . " ";
    $contador--;
} while ($contador >= 1);
echo "<br>";
?>