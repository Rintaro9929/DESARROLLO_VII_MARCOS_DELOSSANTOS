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
    <title>Finalización de Compra</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2em; }
        .cart { margin-bottom: 2em; }
        .cart th, .cart td { padding: 0.5em; border-bottom: 1px solid #ccc; }
        .total { font-weight: bold; }
        .success { color: green; margin-bottom: 1em; }
    </style>
</head>
<body>
    <h1>Finalización de Compra</h1>

    <?php if (isset($mensaje)): ?>
        <div class="success"><?= $mensaje ?></div>
    <?php endif; ?>

    <h2>Resumen del carrito</h2>
    <table class="cart">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($cart as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['qty'] ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td>$<?= number_format($item['price'] * $item['qty'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="total">Total</td>
            <td class="total">$<?= number_format($total, 2) ?></td>
        </tr>
    </table>

    <h2>Datos de envío</h2>
    <form method="post">
        <label for="nombre">Nombre completo:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="direccion">Dirección de envío:</label><br>
        <input type="text" id="direccion" name="direccion" required><br><br>
        <button type="submit">Finalizar compra</button>
    </form>
</body>
</html>