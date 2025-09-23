<?php
// 1. Crear un string JSON con datos de una tienda en línea
$jsonDatos = '
{
    "tienda": "ElectroTech",
    "productos": [
        {"id": 1, "nombre": "Laptop Gamer", "precio": 1200, "categorias": ["electrónica", "computadoras"]},
        {"id": 2, "nombre": "Smartphone 5G", "precio": 800, "categorias": ["electrónica", "celulares"]},
        {"id": 3, "nombre": "Auriculares Bluetooth", "precio": 150, "categorias": ["electrónica", "accesorios"]},
        {"id": 4, "nombre": "Smart TV 4K", "precio": 700, "categorias": ["electrónica", "televisores"]},
        {"id": 5, "nombre": "Tablet", "precio": 300, "categorias": ["electrónica", "computadoras"]}
    ],
    "clientes": [
        {"id": 101, "nombre": "Ana López", "email": "ana@example.com"},
        {"id": 102, "nombre": "Carlos Gómez", "email": "carlos@example.com"},
        {"id": 103, "nombre": "María Rodríguez", "email": "maria@example.com"}
    ]
}
';

// 2. Convertir el JSON a un arreglo asociativo de PHP
$tiendaData = json_decode($jsonDatos, true);

// 3. Función para imprimir los productos
function imprimirProductos($productos) {
    foreach ($productos as $producto) {
        echo "{$producto['nombre']} - \${$producto['precio']} - Categorías: " . implode(", ", $producto['categorias']) . "\n";
    }
}

echo "Productos de {$tiendaData['tienda']}:\n";
imprimirProductos($tiendaData['productos']);

// 4. Calcular el valor total del inventario
$valorTotal = array_reduce($tiendaData['productos'], function($total, $producto) {
    return $total + $producto['precio'];
}, 0);

echo "\nValor total del inventario: \$$valorTotal\n";

// 5. Encontrar el producto más caro
$productoMasCaro = array_reduce($tiendaData['productos'], function($max, $producto) {
    return ($producto['precio'] > $max['precio']) ? $producto : $max;
}, $tiendaData['productos'][0]);

echo "\nProducto más caro: {$productoMasCaro['nombre']} (\${$productoMasCaro['precio']})\n";

// 6. Filtrar productos por categoría
function filtrarPorCategoria($productos, $categoria) {
    return array_filter($productos, function($producto) use ($categoria) {
        return in_array($categoria, $producto['categorias']);
    });
}

$productosDeComputadoras = filtrarPorCategoria($tiendaData['productos'], "computadoras");
echo "\nProductos en la categoría 'computadoras':\n";
imprimirProductos($productosDeComputadoras);

// 7. Agregar un nuevo producto
$nuevoProducto = [
    "id" => 6,
    "nombre" => "Smartwatch",
    "precio" => 250,
    "categorias" => ["electrónica", "accesorios", "wearables"]
];
$tiendaData['productos'][] = $nuevoProducto;

// 8. Convertir el arreglo actualizado de vuelta a JSON
$jsonActualizado = json_encode($tiendaData, JSON_PRETTY_PRINT);
echo "\nDatos actualizados de la tienda (JSON):\n$jsonActualizado\n";

// TAREA: Implementa una función que genere un resumen de ventas
// Crea un arreglo de ventas (producto_id, cliente_id, cantidad, fecha)
// y genera un informe que muestre:
// - Total de ventas
// - Producto más vendido
// - Cliente que más ha comprado

$ventas = [
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 2, "fecha" => "2024-06-01"],
    ["producto_id" => 2, "cliente_id" => 102, "cantidad" => 1, "fecha" => "2024-06-02"],
    ["producto_id" => 3, "cliente_id" => 103, "cantidad" => 3, "fecha" => "2024-06-03"],
    ["producto_id" => 1, "cliente_id" => 102, "cantidad" => 1, "fecha" => "2024-06-04"],
    ["producto_id" => 5, "cliente_id" => 101, "cantidad" => 2, "fecha" => "2024-06-05"],
    ["producto_id" => 3, "cliente_id" => 101, "cantidad" => 1, "fecha" => "2024-06-06"],
    ["producto_id" => 2, "cliente_id" => 103, "cantidad" => 2, "fecha" => "2024-06-07"]
];

function resumenVentas($ventas, $productos, $clientes) {
    $totalVentas = 0;
    $productosVendidos = [];
    $clientesCompras = [];

    foreach ($ventas as $venta) {
        $totalVentas += $venta['cantidad'];
        // Productos vendidos
        if (!isset($productosVendidos[$venta['producto_id']])) {
            $productosVendidos[$venta['producto_id']] = 0;
        }
        $productosVendidos[$venta['producto_id']] += $venta['cantidad'];
        // Clientes compras
        if (!isset($clientesCompras[$venta['cliente_id']])) {
            $clientesCompras[$venta['cliente_id']] = 0;
        }
        $clientesCompras[$venta['cliente_id']] += $venta['cantidad'];
    }

    // Producto más vendido
    $idProductoMasVendido = array_keys($productosVendidos, max($productosVendidos))[0];
    $productoMasVendido = array_filter($productos, function($p) use ($idProductoMasVendido) {
        return $p['id'] == $idProductoMasVendido;
    });
    $productoMasVendido = array_values($productoMasVendido)[0];

    // Cliente que más ha comprado
    $idClienteMasCompras = array_keys($clientesCompras, max($clientesCompras))[0];
    $clienteMasComprador = array_filter($clientes, function($c) use ($idClienteMasCompras) {
        return $c['id'] == $idClienteMasCompras;
    });
    $clienteMasComprador = array_values($clienteMasComprador)[0];

    echo "\n--- Resumen de Ventas ---\n";
    echo "Total de ventas (unidades): $totalVentas\n";
    echo "Producto más vendido: {$productoMasVendido['nombre']} ({$productosVendidos[$idProductoMasVendido]} unidades)\n";
    echo "Cliente que más ha comprado: {$clienteMasComprador['nombre']} ({$clientesCompras[$idClienteMasCompras]} unidades)\n";
}

resumenVentas($ventas, $tiendaData['productos'], $tiendaData['clientes']);

?>