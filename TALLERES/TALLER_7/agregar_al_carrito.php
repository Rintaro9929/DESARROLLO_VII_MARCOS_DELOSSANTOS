<?php
session_start();

error_reporting(0); 
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

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Obtener datos del producto (por ejemplo, desde POST)
$id = isset($_POST['id']) ? $_POST['id'] : null;
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
$cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

if ($id && $nombre && $precio > 0 && $cantidad > 0) {
    // Verificar si el producto ya está en el carrito
    $encontrado = false;
    foreach ($_SESSION['carrito'] as &$producto) {
        if ($producto['id'] == $id) {
            $producto['cantidad'] += $cantidad;
            $encontrado = true;
            break;
        }
    }
    unset($producto);

    // Si no está, agregarlo
    if (!$encontrado) {
        $_SESSION['carrito'][] = [
            'id' => $id,
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad
        ];
    }

    echo "Producto añadido al carrito.";
} else {
    echo "Datos de producto inválidos.";
}
?>