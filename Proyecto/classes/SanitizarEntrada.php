<?php

class SanitizarEntrada
{
    public static function limpiarCadena($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input;
    }

    public static function limpiarEspacios($input)
    {
        return preg_replace('/\s+/', ' ', trim($input));
    }

    public static function CadTitulo($input)
    {
        return ucwords(strtolower(trim($input)));
    }

    public static function validarEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
?>