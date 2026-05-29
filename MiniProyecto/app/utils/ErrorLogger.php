<?php

interface ErrorHandlerInterface
{
    public function registrarError($mensaje);
}

class ErrorLogger implements ErrorHandlerInterface
{
    private $archivo = '../logs/errores.log';

    public function registrarError($mensaje)
    {
        $fecha = date('Y-m-d H:i:s');
        $texto = "[$fecha] ERROR: $mensaje" . PHP_EOL;

        file_put_contents($this->archivo, $texto, FILE_APPEND);
    }
}
?>