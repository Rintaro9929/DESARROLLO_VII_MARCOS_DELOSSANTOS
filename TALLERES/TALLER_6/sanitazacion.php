<?php
function sanitizarNombre($nombre) {
    return htmlspecialchars(trim($nombre));
}

function sanitizarEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function sanitizarFechaNacimiento($fecha) {
    return trim($fecha);
}

function sanitizarSitioWeb($sitioWeb) {
    return filter_var(trim($sitioWeb), FILTER_SANITIZE_URL);
}

function sanitizarGenero($genero) {
    return htmlspecialchars(trim($genero));
}

function sanitizarIntereses($intereses) {
    $sanitizados = [];
    foreach ($intereses as $interes) {
        $sanitizados[] = htmlspecialchars(trim($interes));
    }
    return $sanitizados;
}

function sanitizarComentarios($comentarios) {
    return htmlspecialchars(trim($comentarios));
}
?>