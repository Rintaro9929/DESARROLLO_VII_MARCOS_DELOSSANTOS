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
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    foreach ($_SESSION['carrito'] as $key => $producto) {
        if ($producto['id'] == $id) {
            unset($_SESSION['carrito'][$key]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
            break;
        }
    }
}

header('Location: carrito.php');
exit;
?>