<?php
// Esto nos dirá exactamente cuál es el error
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Diagnóstico del sistema</h2>";

// 1. Verificar estructura de carpetas
echo "<h3>1. Verificando archivos:</h3>";
$carpeta_actual = __DIR__;
echo "Carpeta actual: " . $carpeta_actual . "<br>";

// Verificar si existe la carpeta Modelo
if (file_exists($carpeta_actual . '/Modelo')) {
    echo "✅ Carpeta 'Modelo' existe<br>";
} else {
    echo "❌ Carpeta 'Modelo' NO existe - Debes crearla<br>";
}

// Verificar conexion.php
if (file_exists($carpeta_actual . '/Modelo/conexion.php')) {
    echo "✅ Modelo/conexion.php existe<br>";
} else {
    echo "❌ Modelo/conexion.php NO existe<br>";
}

// Verificar Productos.php
if (file_exists($carpeta_actual . '/Modelo/Productos.php')) {
    echo "✅ Modelo/Productos.php existe<br>";
} else {
    echo "❌ Modelo/Productos.php NO existe<br>";
}

// 2. Verificar conexión a MySQL
echo "<h3>2. Verificando conexión a MySQL:</h3>";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=productosdb", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión a MySQL exitosa<br>";
    
    // Verificar si la tabla existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'productos'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Tabla 'productos' existe<br>";
        $stmt2 = $pdo->query("SELECT COUNT(*) as total FROM productos");
        $resultado = $stmt2->fetch(PDO::FETCH_ASSOC);
        echo "📊 La tabla tiene " . $resultado['total'] . " registros<br>";
    } else {
        echo "❌ Tabla 'productos' NO existe - Debes ejecutar el script SQL<br>";
    }
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
}

// 3. Probar registrar.php directamente
echo "<h3>3. Probando registrar.php:</h3>";
$ch = curl_init('http://localhost/proyecto_crud/registrar.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'accion=Buscar&termino=');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Código HTTP: " . $http_code . "<br>";
echo "Respuesta: <pre>" . htmlspecialchars($response) . "</pre>";

// 4. Verificar si hay error de sintaxis en registrar.php
echo "<h3>4. Verificando sintaxis de registrar.php:</h3>";
$output = shell_exec('php -l "' . $carpeta_actual . '/registrar.php" 2>&1');
echo "<pre>" . htmlspecialchars($output) . "</pre>";
?>