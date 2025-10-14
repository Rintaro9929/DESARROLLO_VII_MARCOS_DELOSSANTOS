<?php
// checkout.php

session_start();

error_reporting(0); // Ocultar errores en producción
ini_set('display_errors', 0);

function mostrarError($mensaje) {
    $_SESSION['error'] = $mensaje;
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'productos.php'));
    exit;
}
function mostrarExito($mensaje) {
    $_SESSION['exito'] = $mensaje;
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'productos.php'));
    exit;
}

// Simulación de productos en el carrito
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [
    ['name' => 'Producto 1', 'price' => 20.00, 'qty' => 1],
    ['name' => 'Producto 2', 'price' => 15.50, 'qty' => 2]
];

// Calcular total
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}

// Procesar formulario de compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí iría la lógica para guardar la orden en la base de datos
    // y procesar el pago (simulado)
    $nombre = htmlspecialchars($_POST['nombre']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $mensaje = "¡Gracias por tu compra, $nombre! Tu pedido será enviado a: $direccion";
    // Vaciar carrito
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra realizada</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="success">
        <h2>¡Compra realizada con éxito!</h2>
        <p>Gracias por tu compra. Pronto recibirás tu pedido.</p>
    </div>
    <div style="text-align:center; margin-top:20px;">
        <a href="productos.php">Volver a productos</a>
    </div>
</body>
</html>