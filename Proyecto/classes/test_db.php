<?php
require_once("classes/myConexionPDO.php");

$db = new mod_db();
echo "✅ Conexión exitosa!<br>";

$result = $db->Arreglos("SHOW TABLES");
echo "📋 Tablas:<br>";
foreach ($result as $row) {
    echo "- " . $row['Tables_in_expedientes'] . "<br>";
}
?>