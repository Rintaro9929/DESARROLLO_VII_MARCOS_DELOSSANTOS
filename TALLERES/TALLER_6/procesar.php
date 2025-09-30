<?php
require_once 'validaciones.php';
require_once 'sanitizacion.php';

// Crear directorios si no existen
if (!file_exists('uploads')) mkdir('uploads');
if (!file_exists('data')) mkdir('data');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    $datos = [];

    // Campos a procesar
    $campos = ['nombre', 'email', 'fecha_nacimiento', 'sitio_web', 'genero', 'intereses', 'comentarios'];
    
    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            $valor = $_POST[$campo];
            $valorSanitizado = call_user_func("sanitizar" . ucfirst($campo), $valor);
            $datos[$campo] = $valorSanitizado;

            if (!call_user_func("validar" . ucfirst($campo), $valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        }
    }

    // Calcular edad automáticamente
    if (isset($datos['fecha_nacimiento'])) {
        $datos['edad'] = calcularEdad($datos['fecha_nacimiento']);
    }

    // Procesar la foto de perfil
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (!validarFotoPerfil($_FILES['foto_perfil'])) {
            $errores[] = "La foto de perfil no es válida.";
        } else {
            // Generar nombre único
            $nombreUnico = generarNombreUnico($_FILES['foto_perfil']['name']);
            $rutaDestino = 'uploads/' . $nombreUnico;
            
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                $datos['foto_perfil'] = $rutaDestino;
            } else {
                $errores[] = "Hubo un error al subir la foto de perfil.";
            }
        }
    }

    // Guardar en JSON si no hay errores
    if (empty($errores)) {
        guardarEnJSON($datos);
    }

    // Mostrar resultados
    if (empty($errores)) {
        echo "<h2>Datos Recibidos:</h2>";
        echo "<table border='1'>";
        foreach ($datos as $campo => $valor) {
            echo "<tr>";
            echo "<th>" . ucfirst($campo) . "</th>";
            if ($campo === 'intereses') {
                echo "<td>" . implode(", ", $valor) . "</td>";
            } elseif ($campo === 'foto_perfil') {
                echo "<td><img src='$valor' width='100'></td>";
            } else {
                echo "<td>$valor</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>Errores:</h2>";
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }

    echo "<br><a href='formulario.html'>Volver al formulario</a>";
    echo "<br><a href='resumen.php'>Ver Resumen de Registros</a>";
}

function guardarEnJSON($datos) {
    $archivo = 'data/registros.json';
    $registros = [];
    
    if (file_exists($archivo)) {
        $contenido = file_get_contents($archivo);
        $registros = json_decode($contenido, true) ?: [];
    }
    
    // Agregar fecha de registro
    $datos['fecha_registro'] = date('Y-m-d H:i:s');
    
    $registros[] = $datos;
    file_put_contents($archivo, json_encode($registros, JSON_PRETTY_PRINT));
}
?>