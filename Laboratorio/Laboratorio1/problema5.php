## Problema #5 corregido - `problema5.php`
```php
<?php
$texto_original = "";
$texto_trim = "";
$texto_sanitizado = "";
$texto_normalizado = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['texto'])) {
        $texto_original = $_POST['texto'];
        
        $texto_trim = trim($texto_original);
        
        $texto_sanitizado = htmlspecialchars(strip_tags($texto_original), ENT_QUOTES, 'UTF-8');
        
        $texto_normalizado = strtolower($texto_trim);
        $texto_normalizado = preg_replace('/[^a-z0-9\s]/', '', $texto_normalizado);
        $texto_normalizado = preg_replace('/\s+/', ' ', $texto_normalizado);
    } else {
        $error = "Por favor, ingrese un texto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema #5 - Sanitización, Normalización y Trimming</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <a href="Laboratorio.php" class="btn btn-volver">Volver al menú principal</a>
        
        <div class="main-header">
            <h1>Problema #5</h1>
            <p>Sanitización, Normalización y Trimming</p>
        </div>

        <div style="background: white; border-radius: 15px; padding: 30px; max-width: 650px; margin: 0 auto;">
            <div class="info">
                <strong>Conceptos:</strong><br>
                Trimming: Eliminar espacios en blanco al inicio y final del texto<br>
                Sanitización: Limpiar caracteres peligrosos (HTML, scripts)<br>
                Normalización: Convertir a minúsculas, eliminar símbolos y espacios múltiples
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Ingrese un texto (incluya espacios al inicio y final):</label>
                    <input type="text" name="texto" value="<?php echo htmlspecialchars($texto_original); ?>" placeholder="Ejemplo:     Hola   Mundo!    " style="font-family: monospace;">
                    <small style="display: block; margin-top: 5px; color: #666;">Prueba: "    Hola   Mundo!    " (con espacios)</small>
                </div>
                <button type="submit" class="btn btn-calcular">Procesar Texto</button>
            </form>
            
            <?php if ($texto_original !== "" && !$error): ?>
                <div style="margin-top: 25px;">
                    <div class="result" style="margin-bottom: 15px; text-align: left;">
                        <div class="result-label">TEXTO ORIGINAL</div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; font-family: monospace; font-size: 16px; margin-top: 5px; border-left: 3px solid #667eea;">
                            "<strong><?php echo htmlspecialchars($texto_original); ?></strong>"
                        </div>
                        <div style="font-size: 12px; color: #666; margin-top: 5px;">
                            Longitud: <?php echo strlen($texto_original); ?> caracteres
                            <?php if (strlen($texto_original) > strlen(trim($texto_original))): ?>
                                <span style="color: #f57c00;">Tiene espacios al inicio o final</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="result" style="margin-bottom: 15px; text-align: left; background: #e3f2fd;">
                        <div class="result-label">TRIMMING (Eliminar espacios al inicio y final)</div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; font-family: monospace; font-size: 16px; margin-top: 5px; border-left: 3px solid #2196f3;">
                            "<strong><?php echo htmlspecialchars($texto_trim); ?></strong>"
                        </div>
                        <div style="font-size: 12px; color: #666; margin-top: 5px;">
                            Longitud: <?php echo strlen($texto_trim); ?> caracteres
                            <?php if (strlen($texto_original) > strlen($texto_trim)): ?>
                                <span style="color: #4caf50;">Se eliminaron <?php echo strlen($texto_original) - strlen($texto_trim); ?> espacios</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="result" style="margin-bottom: 15px; text-align: left; background: #fff3e0;">
                        <div class="result-label">SANITIZACIÓN (Limpiar caracteres HTML/scripts)</div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; font-family: monospace; font-size: 16px; margin-top: 5px; border-left: 3px solid #ff9800;">
                            "<?php echo htmlspecialchars($texto_sanitizado); ?>"
                        </div>
                        <div style="font-size: 12px; color: #666; margin-top: 5px;">
                            Caracteres como &lt; &gt; &quot; se convierten en entidades HTML
                        </div>
                    </div>
                    
                    <div class="result" style="text-align: left; background: #e8f5e9;">
                        <div class="result-label">NORMALIZACIÓN (Minúsculas + sin símbolos + espacios simples)</div>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 8px; font-family: monospace; font-size: 16px; margin-top: 5px; border-left: 3px solid #4caf50;">
                            "<?php echo htmlspecialchars($texto_normalizado); ?>"
                        </div>
                        <div style="font-size: 12px; color: #666; margin-top: 5px;">
                            Todo en minúsculas | Sin caracteres especiales | Espacios simples
                        </div>
                    </div>
                </div>
                
                <div class="info" style="margin-top: 20px; background: #e8f5e9;">
                    <strong>Resumen:</strong><br>
                    Texto original: <?php echo strlen($texto_original); ?> caracteres<br>
                    Después de Trim: <?php echo strlen($texto_trim); ?> caracteres<br>
                    <?php if (strlen($texto_original) > strlen($texto_trim)): ?>
                        Se eliminaron <?php echo strlen($texto_original) - strlen($texto_trim); ?> espacios en blanco al inicio y/o final
                    <?php else: ?>
                        No había espacios al inicio o final
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($texto_original === "" && $_SERVER["REQUEST_METHOD"] == "POST"): ?>
                <div class="error">Por favor, ingrese un texto para procesar.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
```