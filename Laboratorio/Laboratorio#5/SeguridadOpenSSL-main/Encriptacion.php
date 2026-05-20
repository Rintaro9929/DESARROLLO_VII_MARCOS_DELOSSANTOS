<?php

$ivHex = "";
$textoCifrado = "";
$textoDescifrado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mensaje = trim($_POST["mensaje"]);
    $clave = trim($_POST["clave"]);

    if (!empty($mensaje) && !empty($clave)) {

        // Normalizar clave a 16 caracteres
        $clave = str_pad(substr($clave, 0, 16), 16, "0");

        $metodo = "AES-128-CBC";

        // Generar IV dinámico
        $iv = openssl_random_pseudo_bytes(
            openssl_cipher_iv_length($metodo)
        );

        // Cifrar
        $textoCifrado = openssl_encrypt(
            $mensaje,
            $metodo,
            $clave,
            0,
            $iv
        );

        // Descifrar
        $textoDescifrado = openssl_decrypt(
            $textoCifrado,
            $metodo,
            $clave,
            0,
            $iv
        );

        // Convertir IV a hexadecimal
        $ivHex = bin2hex($iv);
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Encriptación OpenSSL</title>

<style>

body{
    font-family: Arial;
    background:#f4f4f4;
    padding:40px;
}

.container{
    width:700px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
}

textarea,input{
    width:100%;
    padding:10px;
    margin-top:10px;
    margin-bottom:20px;
}

button{
    padding:10px 20px;
    background:#007bff;
    color:white;
    border:none;
    cursor:pointer;
}

.resultado{
    background:#eee;
    padding:15px;
    margin-top:20px;
    border-radius:5px;
}

</style>

</head>

<body>

<div class="container">

<h1>Cifrado Simétrico AES-128-CBC</h1>

<form method="POST">

<label>Mensaje en Claro</label>

<textarea name="mensaje" rows="5"></textarea>

<label>Clave Secreta Compartida</label>

<input type="text" name="clave">

<button type="submit">Encriptar</button>

</form>

<?php if(!empty($textoCifrado)): ?>

<div class="resultado">

<h3>IV en Hexadecimal</h3>

<p><?= $ivHex ?></p>

</div>

<div class="resultado">

<h3>Texto Cifrado</h3>

<p><?= $textoCifrado ?></p>

</div>

<div class="resultado">

<h3>Texto Descifrado</h3>

<p><?= $textoDescifrado ?></p>

</div>

<?php endif; ?>

</div>

</body>
</html>