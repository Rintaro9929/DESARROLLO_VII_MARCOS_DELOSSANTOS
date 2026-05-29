<?php

class Utilidades
{
    public static function calcularPromedio($numeros)
    {
        return array_sum($numeros) / count($numeros);
    }

    public static function calcularDesviacion($numeros)
    {
        $promedio = self::calcularPromedio($numeros);
        $suma = 0;

        foreach ($numeros as $numero) {
            $suma += pow($numero - $promedio, 2);
        }

        return sqrt($suma / count($numeros));
    }

    public static function obtenerMaximo($numeros)
    {
        return max($numeros);
    }

    public static function obtenerMinimo($numeros)
    {
        return min($numeros);
    }
}
?>