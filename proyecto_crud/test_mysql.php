<?php
// test_mysql.php
header('Content-Type: text/html; charset=utf-8');

echo "<h2>Diagnóstico de MySQL</h2>";

// Probar diferentes puertos
$puertos = [3306, 3307, 3308];

foreach ($puertos as $puerto) {
    echo "<h3>Probando puerto $puerto:</h3>";
    try {
        $pdo = new PDO("mysql:host=localhost;port=$puerto", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Conexión exitosa en puerto $puerto<br>";
        
        // Listar bases de datos
        $stmt = $pdo->query("SHOW DATABASES");
        $dbs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "📊 Bases de datos disponibles: " . implode(', ', $dbs) . "<br>";
        
        // Verificar si existe productosdb
        if (in_array('productosdb', $dbs)) {
            echo "✅ Base de datos 'productosdb' encontrada<br>";
            $pdo->exec("USE productosdb");
            $stmt2 = $pdo->query("SELECT COUNT(*) as total FROM productos");
            $result = $stmt2->fetch(PDO::FETCH_ASSOC);
            echo "📦 Tabla 'productos' tiene " . $result['total'] . " registros<br>";
        } else {
            echo "❌ Base de datos 'productosdb' NO existe<br>";
        }
        
        break; // Si funciona, salir del ciclo
    } catch (PDOException $e) {
        echo "❌ Puerto $puerto: " . $e->getMessage() . "<br>";
    }
}
?>