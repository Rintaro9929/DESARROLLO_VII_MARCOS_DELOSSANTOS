<?php

// Forzar ruta del archivo openssl.cnf
putenv("OPENSSL_CONF=C:/xampp/php/extras/ssl/openssl.cnf");

// Datos a firmar
$datos = 'Este texto será firmado. Thanks for your attention :)';

// Configuración OpenSSL
$configArgs = array(
    "config" => "C:/xampp/php/extras/ssl/openssl.cnf",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

// Crear claves
$resourceNewKeyPair = openssl_pkey_new($configArgs);

// Verificar errores
if (!$resourceNewKeyPair) {

    echo "<h2>Error al generar las claves</h2>";

    while ($msg = openssl_error_string()) {
        echo $msg . "<br>";
    }

    exit;
}

// Obtener clave pública
$details = openssl_pkey_get_details($resourceNewKeyPair);

$publicKeyPem = $details['key'];

// Exportar clave privada
if (!openssl_pkey_export($resourceNewKeyPair, $privateKeyPem, NULL, $configArgs)) {

    echo "<h2>Error exportando clave privada</h2>";

    while ($msg = openssl_error_string()) {
        echo $msg . "<br>";
    }

    exit;
}

// Crear carpeta keys si no existe
if (!file_exists('keys')) {

    mkdir('keys', 0777, true);
}

// Guardar claves
file_put_contents('keys/private_key.pem', $privateKeyPem);

file_put_contents('keys/public_key.pem', $publicKeyPem);

// Obtener clave privada
$resourcePrivateKey = openssl_pkey_get_private($privateKeyPem);

// Firmar datos
if (!openssl_sign($datos, $firma, $resourcePrivateKey, OPENSSL_ALGO_SHA256)) {

    echo "<h2>Error al firmar</h2>";

    while ($msg = openssl_error_string()) {
        echo $msg . "<br>";
    }

    exit;
}

// Guardar firma
file_put_contents('keys/signature.dat', $firma);

// Verificar firma
$verificacion = openssl_verify(
    $datos,
    $firma,
    $publicKeyPem,
    OPENSSL_ALGO_SHA256
);

// Mostrar resultados
echo "<h1>Firma Digital OpenSSL</h1>";

echo "<h3>Mensaje:</h3>";
echo $datos;

echo "<hr>";

if ($verificacion === 1) {

    echo "<h2>La firma es válida y los datos son confiables</h2>";

} else {

    echo "<h2>La firma es inválida o los datos fueron alterados</h2>";
}

?>