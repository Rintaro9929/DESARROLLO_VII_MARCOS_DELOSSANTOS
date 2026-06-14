<?php
// prueba_bd.php
header('Content-Type: application/json');

try {
    // Conectar usando puerto 3307
    $pdo = new PDO("mysql:host=localhost;port=3307;dbname=productosdb", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $productos,
        'count' => count($productos)
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>