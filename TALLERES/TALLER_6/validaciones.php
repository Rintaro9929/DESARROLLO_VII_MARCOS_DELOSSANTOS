<?php
function validarNombre($nombre) {
    return !empty($nombre) && strlen($nombre) <= 50;
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validarFechaNacimiento($fecha) {
    if (empty($fecha)) return false;
    
    // Calcular edad
    $fechaNacimiento = new DateTime($fecha);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;
    
    return $edad >= 18 && $edad <= 120;
}

function calcularEdad($fechaNacimiento) {
    $fechaNac = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    return $hoy->diff($fechaNac)->y;
}

function validarSitioWeb($sitioWeb) {
    return empty($sitioWeb) || filter_var($sitioWeb, FILTER_VALIDATE_URL);
}

function validarGenero($genero) {
    $generosValidos = ['masculino', 'femenino', 'otro'];
    return in_array($genero, $generosValidos);
}

function validarIntereses($intereses) {
    if (empty($intereses)) return false;
    
    $interesesValidos = ['deportes', 'musica', 'lectura'];
    foreach ($intereses as $interes) {
        if (!in_array($interes, $interesesValidos)) {
            return false;
        }
    }
    return true;
}

function validarComentarios($comentarios) {
    return strlen($comentarios) <= 500;
}

function validarFotoPerfil($archivo) {
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    $tamanoMaximo = 1 * 1024 * 1024; // 1MB

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (!in_array($archivo['type'], $tiposPermitidos)) {
        return false;
    }

    if ($archivo['size'] > $tamanoMaximo) {
        return false;
    }

    return true;
}

function generarNombreUnico($nombreOriginal) {
    $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
    $nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
    return $nombreBase . '_' . time() . '.' . $extension;
}
?>