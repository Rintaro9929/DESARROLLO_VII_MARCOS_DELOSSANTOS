<?php

class Sanitizador
{
    public static function limpiarTexto($texto)
    {
        return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
    }

    public static function limpiarNumero($numero)
    {
        return filter_var($numero, FILTER_VALIDATE_INT);
    }

    public static function limpiarDecimal($numero)
    {
        return filter_var($numero, FILTER_VALIDATE_FLOAT);
    }
}