<?php
$archivo = 'data/registros.json';

echo "<h2>Resumen de Todos los Registros</h2>";

if (!file_exists($archivo)) {
    echo "<p>No hay registros aún.</p>";
    echo "<a href='formulario.html'>Ir al Formulario</a>";
    exit;
}

$contenido = file_get_contents($archivo);
$registros = json_decode($contenido, true);

if (empty($registros)) {
    echo "<p>No hay registros aún.</p>";
} else {
    echo "<p>Total de registros: " . count($registros) . "</p>";
    
    foreach ($registros as $indice => $registro) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        echo "<h3>Registro #" . ($indice + 1) . "</h3>";
        echo "<p><strong>Nombre:</strong> " . htmlspecialchars($registro['nombre']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($registro['email']) . "</p>";
        echo "<p><strong>Edad:</strong> " . $registro['edad'] . " años</p>";
        echo "<p><strong>Fecha de Nacimiento:</strong> " . $registro['fecha_nacimiento'] . "</p>";
        echo "<p><strong>Género:</strong> " . htmlspecialchars($registro['genero']) . "</p>";
        
        if (!empty($registro['intereses'])) {
            echo "<p><strong>Intereses:</strong> " . implode(", ", $registro['intereses']) . "</p>";
        }
        
        if (!empty($registro['comentarios'])) {
            echo "<p><strong>Comentarios:</strong> " . htmlspecialchars($registro['comentarios']) . "</p>";
        }
        
        if (!empty($registro['foto_perfil'])) {
            echo "<p><strong>Foto:</strong> <img src='" . $registro['foto_perfil'] . "' width='50'></p>";
        }
        
        echo "<p><strong>Fecha de Registro:</strong> " . $registro['fecha_registro'] . "</p>";
        echo "</div>";
    }
}

echo "<br><a href='formulario.html'>Volver al Formulario</a>";
?>