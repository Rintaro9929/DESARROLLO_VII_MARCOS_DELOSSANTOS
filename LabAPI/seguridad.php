<?php

require_once 'vendor/autoload.php';
require_once 'config/config.php';

use Marco\LabApi\AuthService;

$headers = getallheaders();

if (!isset($headers['Authorization'])) {

    http_response_code(401);

    echo json_encode([
        "error" => "Token requerido"
    ]);

    exit;
}

$token = str_replace(
    'Bearer ',
    '',
    $headers['Authorization']
);

try {

    AuthService::validarToken(
        $token
    );

} catch (Exception $e) {

    http_response_code(401);

    echo json_encode([
        "error" => "Token inválido"
    ]);

    exit;
}