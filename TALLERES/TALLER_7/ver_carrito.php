<?php
session_start();

error_reporting(0); // Ocultw los errores en producción
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
// Medidas de seguridad básicas para la sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Eliminar producto del carrito
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
    }
    header("Location: ver_carrito.php");
    exit;
}

// Proceso de checkout
if (isset($_POST['checkout'])) {
    $nombre = trim($_POST['nombre']);
    $total = 0;
    $resumen = [];

    if (!empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $id => $item) {
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
            $resumen[] = "{$item['nombre']} x {$item['cantidad']} = $" . number_format($subtotal, 2);
        }
    }

    // Guardar nombre en cookie por 24 horas
    if ($nombre) {
        setcookie('usuario', htmlspecialchars($nombre), time() + 86400, "", "", false, true);
    }

    // Vaciar carrito
    $_SESSION['carrito'] = [];

    echo "<h2>¡Gracias por tu compra, " . htmlspecialchars($nombre) . "!</h2>";
    echo "<h3>Resumen de la compra:</h3>";
    echo "<ul>";
    foreach ($resumen as $linea) {
        echo "<li>$linea</li>";
    }
    echo "</ul>";
    echo "<strong>Total: $" . number_format($total, 2) . "</strong>";
    echo "<br><a href='productos.php'>Volver a productos</a>";
    exit;
}

// Mostrar carrito
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Carrito de Compras</h2>
    <?php if (!empty($_SESSION['carrito'])): ?>
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
            <?php foreach ($_SESSION['carrito'] as $id => $item): 
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['nombre']) ?></td>
                <td>$<?= number_format($item['precio'], 2) ?></td>
                <td><?= $item['cantidad'] ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td>
                    <a class="acciones" href="ver_carrito.php?eliminar=<?= urlencode($id) ?>" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
            </tr>
        </table>
        <form method="post" style="margin:20px;">
            <label>Tu nombre para la compra: 
                <input type="text" name="nombre" required value="<?= isset($_COOKIE['usuario']) ? htmlspecialchars($_COOKIE['usuario']) : '' ?>">
            </label>
            <button type="submit" name="checkout">Finalizar compra</button>
        </form>
    <?php else: ?>
        <p>El carrito está vacío.</p>
    <?php endif; ?>
    <a href="productos.php">Volver a productos</a>
</body>
</html>