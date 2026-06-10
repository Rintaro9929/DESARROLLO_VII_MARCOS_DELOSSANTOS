<?php

header('Content-Type: application/json');

require_once 'vendor/autoload.php';
require_once 'config/config.php';

use Marco\LabApi\AuthService;

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$usuario = $data['usuario'] ?? '';
$password = $data['password'] ?? '';

$hashAdmin = password_hash(
    '12345',
    PASSWORD_BCRYPT
);

if (
    $usuario === 'admin' &&
    password_verify($password, $hashAdmin)
) {

    $token = AuthService::generarToken(
        $usuario
    );

    echo json_encode([
        "token" => $token
    ]);

} else {

    http_response_code(401);

    echo json_encode([
        "error" => "Credenciales inválidas"
    ]);
}