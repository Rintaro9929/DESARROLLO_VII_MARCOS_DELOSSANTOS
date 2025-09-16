<?php
define('ARCHIVO_INVENTARIO', 'inventario.json');

function leerInventario() {
    if (!file_exists(ARCHIVO_INVENTARIO)) {
        throw new Exception("El archivo " . ARCHIVO_INVENTARIO . " no existe.");
    }
    
    $contenido = file_get_contents(ARCHIVO_INVENTARIO);
    
    if ($contenido === false) {
        throw new Exception("No se pudo leer el archivo " . ARCHIVO_INVENTARIO);
    }
    
    $inventario = json_decode($contenido, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error al decodificar JSON: " . json_last_error_msg());
    }
    
    return $inventario;
}

function ordenarInventarioPorNombre($inventario) {
    $inventarioOrdenado = $inventario;
    
    usort($inventarioOrdenado, function($a, $b) {
        return strcasecmp($a['nombre'], $b['nombre']);
    });
    
    return $inventarioOrdenado;
}

function mostrarResumenInventario($inventario) {
    echo "============================================\n";
    echo "         RESUMEN DEL INVENTARIO\n";
    echo "============================================\n";
    echo str_pad("NOMBRE", 15) . str_pad("PRECIO", 12) . str_pad("CANTIDAD", 10) . "VALOR TOTAL\n";
    echo "--------------------------------------------\n";
    
    $totalGeneral = 0;
    
    foreach ($inventario as $producto) {
        $valorTotal = $producto['precio'] * $producto['cantidad'];
        $totalGeneral += $valorTotal;
        
        echo str_pad($producto['nombre'], 15) . 
             str_pad('$' . number_format($producto['precio'], 2), 12) . 
             str_pad($producto['cantidad'], 10) . 
             '$' . number_format($valorTotal, 2) . "\n";
    }
    
    echo "--------------------------------------------\n";
    echo str_pad("TOTAL GENERAL:", 37) . '$' . number_format($totalGeneral, 2) . "\n";
    echo "============================================\n\n";
}

function calcularValorTotalInventario($inventario) {
    $valoresProductos = array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario);
    
    return array_sum($valoresProductos);
}

function generarInformeStockBajo($inventario, $umbralStock = 5) {
    $productosStockBajo = array_filter($inventario, function($producto) use ($umbralStock) {
        return $producto['cantidad'] < $umbralStock;
    });
    
    return $productosStockBajo;
}

function mostrarInformeStockBajo($productosStockBajo, $umbralStock = 5) {
    if (empty($productosStockBajo)) {
        echo "✅ No hay productos con stock bajo (menos de $umbralStock unidades).\n\n";
        return;
    }
    
    echo "⚠️  PRODUCTOS CON STOCK BAJO (menos de $umbralStock unidades)\n";
    echo "============================================\n";
    echo str_pad("NOMBRE", 15) . str_pad("STOCK ACTUAL", 15) . str_pad("UMBRAL", 10) . "\n";
    echo "--------------------------------------------\n";
    
    foreach ($productosStockBajo as $producto) {
        echo str_pad($producto['nombre'], 15) . 
             str_pad($producto['cantidad'], 15) . 
             str_pad($umbralStock, 10) . "\n";
    }
    
    echo "============================================\n\n";
}

try {
    echo "\n🔧 SISTEMA DE GESTIÓN DE INVENTARIO JSON\n";
    echo "============================================\n\n";
    
    echo "📖 Leyendo inventario desde " . ARCHIVO_INVENTARIO . "...\n";
    $inventario = leerInventario();
    echo "✅ Inventario cargado correctamente (" . count($inventario) . " productos)\n\n";
    
    echo "🔠 Ordenando inventario alfabéticamente...\n";
    $inventarioOrdenado = ordenarInventarioPorNombre($inventario);
    
    mostrarResumenInventario($inventarioOrdenado);
    
    $valorTotal = calcularValorTotalInventario($inventario);
    echo "💰 VALOR TOTAL DEL INVENTARIO: $" . number_format($valorTotal, 2) . "\n\n";
    
    echo "📊 Generando informe de stock bajo...\n";
    $productosStockBajo = generarInformeStockBajo($inventario);
    mostrarInformeStockBajo($productosStockBajo);
    
    echo "✅ Proceso completado exitosamente.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}