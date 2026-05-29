<?php
include 'header.php';

$pares = 0;
$impares = 0;

for ($i = 1; $i <= 200; $i++) {

    if ($i % 2 == 0) {
        $pares += $i;
    } else {
        $impares += $i;
    }
}
?>

<h2>Problema #4</h2>

<p>Suma pares: <?php echo $pares; ?></p>
<p>Suma impares: <?php echo $impares; ?></p>

<?php include 'footer.php'; ?>