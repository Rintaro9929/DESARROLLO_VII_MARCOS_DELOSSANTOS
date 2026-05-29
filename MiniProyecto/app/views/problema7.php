<?php
$mes = 5;

switch ($mes) {

    case 12:
    case 1:
    case 2:
        echo "Invierno";
        break;

    case 3:
    case 4:
    case 5:
        echo "Primavera";
        break;

    case 6:
    case 7:
    case 8:
        echo "Verano";
        break;

    default:
        echo "Otoño";
}