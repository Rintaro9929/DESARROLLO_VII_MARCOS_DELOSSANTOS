<?php

namespace Marco\LabApi;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    public static function generarToken($usuario)
    {
        $payload = [
            "iat" => time(),
            "exp" => time() + 3600,
            "usuario" => $usuario
        ];

        return JWT::encode(
            $payload,
            JWT_SECRET_KEY,
            'HS256'
        );
    }

    public static function validarToken($token)
    {
        return JWT::decode(
            $token,
            new Key(JWT_SECRET_KEY, 'HS256')
        );
    }
}