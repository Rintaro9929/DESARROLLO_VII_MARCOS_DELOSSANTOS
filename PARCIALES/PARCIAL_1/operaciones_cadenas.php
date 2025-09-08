<?php
// operaciones_cadenas

function contar_palabras_repetidas($texto) {

    $texto = trim($texto);
    $palabras = explode(' ', $texto);
    $contador = [];
    
    foreach ($palabras as $palabra) {
        
        $palabra = strtolower(trim($palabra));
        
     
        if (!empty($palabra)) {
            if (isset($contador[$palabra])) {
                $contador[$palabra]++;
            } else {
                $contador[$palabra] = 1;
            }
        }
    }
    
    return $contador;
}

function capitalizar_palabras($texto) {
    
    $palabras = explode(' ', $texto);
    $resultado = [];
    
    foreach ($palabras as $palabra) {
        if (strlen($palabra) > 0) {
            
            $primera_letra = strtoupper(substr($palabra, 0, 1));
            $resto = strtolower(substr($palabra, 1));
            $resultado[] = $primera_letra . $resto;
        }
    }
    
    
    return implode(' ', $resultado);
}
?>