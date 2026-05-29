<?php

class Sanitizador
{
    public static function limpiarTexto($texto)
    {
        return htmlspecialchars(trim($texto));
    }

    public static function limpiarCorreo($correo)
    {
        return filter_var($correo, FILTER_SANITIZE_EMAIL);
    }

    public static function limpiarNumero($numero)
    {
        return filter_var($numero, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
?>
