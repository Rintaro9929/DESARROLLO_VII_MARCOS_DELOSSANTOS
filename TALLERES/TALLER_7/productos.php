<?php
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
// Medidas de seguridad básicas para sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

// Lista de productos
$productos = [
    1 => ['nombre' => 'Laptop', 'precio' => 1200.00],
    2 => ['nombre' => 'Smartphone', 'precio' => 800.00],
    3 => ['nombre' => 'Auriculares', 'precio' => 150.00],
    4 => ['nombre' => 'Monitor', 'precio' => 300.00],
    5 => ['nombre' => 'Teclado', 'precio' => 50.00],
];

// Añadir producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $id = intval($_POST['producto_id']);
    if (isset($productos[$id])) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += 1;
        } else {
            $_SESSION['carrito'][$id] = [
                'nombre' => $productos[$id]['nombre'],
                'precio' => $productos[$id]['precio'],
                'cantidad' => 1
            ];
        }
        header('Location: productos.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <style>
        table { border-collapse: collapse; width: 50%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        form { margin: 0; }
        .carrito-link { margin: 20px auto; display: block; width: 50%; text-align: right; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Lista de Productos</h2>
    <a class="carrito-link" href="ver_carrito.php">Ver Carrito (<?php echo isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0; ?>)</a>
    <table>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($productos as $id => $producto): ?>
        <tr>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo number_format($producto['precio'], 2); ?></td>
            <td>
                <form method="post" action="productos.php">
                    <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                    <button type="submit">Añadir al carrito</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>