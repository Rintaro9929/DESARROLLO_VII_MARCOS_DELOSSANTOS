<?php
try {
    $pdo = new PDO('mysql:host=localhost;port=3307;dbname=expedientes;charset=utf8mb4', 'usuario_lab', 'password_seguro');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión exitosa a la base de datos!";
    
    // Probar consulta
    $stmt = $pdo->query("SHOW TABLES");
    echo "<br>📋 Tablas en la base de datos:<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . $row['Tables_in_expedientes'] . "</li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>