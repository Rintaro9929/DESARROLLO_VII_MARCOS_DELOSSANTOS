<?php

class Navegacion
{
    public static function volverMenu(string $ruta): string
    {
        return '<a href="' . $ruta . '" class="btn-volver">Volver al menú principal</a>';
    }
}