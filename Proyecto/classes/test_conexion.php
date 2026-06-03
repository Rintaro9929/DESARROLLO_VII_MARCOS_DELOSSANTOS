<?php
require_once("myConexionPDO.php");

$db = new mod_db();

// Probar conexión
if ($db->getConexion()) {
    echo "✅ Conexión exitosa a la base de datos<br>";
    
    // Probar consulta - CORREGIDO: $query definida
    $query = "SHOW TABLES";
    $result = $db->Arreglos($query);
    
    if (is_array($result)) {
        echo "<br>📋 Tablas en la base de datos:<br><ul>";
        foreach ($result as $row) {
            echo "<li>" . $row['Tables_in_expedientes'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No se pudieron obtener las tablas";
    }
    
    // Contar usuarios
    $query2 = "SELECT COUNT(*) as total FROM usuarios";
    $totalUsuarios = $db->Arreglos($query2);
    if (is_array($totalUsuarios) && isset($totalUsuarios[0]['total'])) {
        echo "<br>👥 Total de usuarios registrados: " . $totalUsuarios[0]['total'];
    }
    
} else {
    echo "❌ Error de conexión a la base de datos";
}

$db->disconnect();
?>