<?php
$edades = [10, 15, 25, 70, 8];

foreach ($edades as $edad) {

    switch (true) {

        case ($edad >= 0 && $edad <= 12):
            echo "Niño <br>";
            break;

        case ($edad >= 13 && $edad <= 17):
            echo "Adolescente <br>";
            break;

        case ($edad >= 18 && $edad <= 64):
            echo "Adulto <br>";
            break;

        default:
            echo "Adulto Mayor <br>";
    }
}