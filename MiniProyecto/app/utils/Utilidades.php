<?php

class Utilidades
{
    /**
     * Calcula el promedio de un arreglo de números.
     *
     * @param array $numeros
     * @return float
     */
    public static function calcularPromedio(array $numeros): float
    {
        if (empty($numeros)) {
            return 0;
        }

        return array_sum($numeros) / count($numeros);
    }

    /**
     * Calcula la desviación estándar.
     *
     * @param array $numeros
     * @return float
     */
    public static function calcularDesviacion(array $numeros): float
    {
        if (empty($numeros)) {
            return 0;
        }

        $promedio = self::calcularPromedio($numeros);
        $suma = 0;

        foreach ($numeros as $numero) {
            $suma += pow($numero - $promedio, 2);
        }

        return sqrt($suma / count($numeros));
    }

    /**
     * Obtiene el valor máximo.
     *
     * @param array $numeros
     * @return float|int
     */
    public static function obtenerMaximo(array $numeros)
    {
        return empty($numeros) ? 0 : max($numeros);
    }

    /**
     * Obtiene el valor mínimo.
     *
     * @param array $numeros
     * @return float|int
     */
    public static function obtenerMinimo(array $numeros)
    {
        return empty($numeros) ? 0 : min($numeros);
    }

    /**
     * Calcula la suma de números pares en un rango.
     *
     * @param int $inicio
     * @param int $fin
     * @return int
     */
    public static function sumarPares(int $inicio, int $fin): int
    {
        $suma = 0;

        for ($i = $inicio; $i <= $fin; $i++) {

            if ($i % 2 == 0) {
                $suma += $i;
            }
        }

        return $suma;
    }

    /**
     * Calcula la suma de números impares en un rango.
     *
     * @param int $inicio
     * @param int $fin
     * @return int
     */
    public static function sumarImpares(int $inicio, int $fin): int
    {
        $suma = 0;

        for ($i = $inicio; $i <= $fin; $i++) {

            if ($i % 2 != 0) {
                $suma += $i;
            }
        }

        return $suma;
    }

    /**
     * Calcula la suma de un rango de números.
     *
     * @param int $inicio
     * @param int $fin
     * @return int
     */
    public static function sumarRango(int $inicio, int $fin): int
    {
        $suma = 0;

        for ($i = $inicio; $i <= $fin; $i++) {
            $suma += $i;
        }

        return $suma;
    }

    /**
     * Clasifica una edad según su rango.
     *
     * @param int $edad
     * @return string
     */
    public static function clasificarEdad(int $edad): string
    {
        switch (true) {

            case ($edad >= 0 && $edad <= 12):
                return 'Niño';

            case ($edad >= 13 && $edad <= 17):
                return 'Adolescente';

            case ($edad >= 18 && $edad <= 64):
                return 'Adulto';

            default:
                return 'Adulto Mayor';
        }
    }

    /**
     * Distribuye un presupuesto hospitalario.
     *
     * @param float $presupuesto
     * @return array
     */
    public static function distribuirPresupuesto(float $presupuesto): array
    {
        return [
            'ginecologia' => $presupuesto * 0.40,
            'traumatologia' => $presupuesto * 0.35,
            'pediatria' => $presupuesto * 0.25
        ];
    }

    /**
     * Obtiene la estación del año según el número de mes.
     *
     * @param int $mes
     * @return string
     */
    public static function obtenerEstacion(int $mes): string
    {
        switch ($mes) {

            case 12:
            case 1:
            case 2:
                return 'Invierno';

            case 3:
            case 4:
            case 5:
                return 'Primavera';

            case 6:
            case 7:
            case 8:
                return 'Verano';

            case 9:
            case 10:
            case 11:
                return 'Otoño';

            default:
                return 'Mes inválido';
        }
    }

    /**
     * Genera las potencias de un número.
     *
     * @param int $base
     * @param int $limite
     * @return array
     */
    public static function generarPotencias(int $base, int $limite): array
    {
        $resultado = [];

        for ($i = 1; $i <= $limite; $i++) {
            $resultado[] = "$base ^ $i = " . pow($base, $i);
        }

        return $resultado;
    }
}

?>