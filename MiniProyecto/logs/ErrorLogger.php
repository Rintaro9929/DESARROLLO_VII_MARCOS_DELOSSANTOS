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
        // Crear carpeta logs si no existe
        $directorio = dirname($this->archivo);

        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $fecha = date('Y-m-d H:i:s');
        $texto = "[$fecha] ERROR: $mensaje" . PHP_EOL;

        if (file_put_contents($this->archivo, $texto, FILE_APPEND) === false) {
            throw new Exception("No se pudo registrar el error en el archivo de log.");
        }
    }
}
?>