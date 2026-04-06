<?php
$numero1 = "";
$numero2 = "";
$resultado = "";
$operacion = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero1 = trim($_POST['numero1'] ?? "");
    $numero2 = trim($_POST['numero2'] ?? "");
    $operacion = trim($_POST['operacion'] ?? "");
    
    $numero1 = filter_var($numero1, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $numero2 = filter_var($numero2, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $operacion = htmlspecialchars(strip_tags($operacion));
    
    $numero1 = str_replace(",", ".", $numero1);
    $numero2 = str_replace(",", ".", $numero2);
    
    if (empty($numero1) || empty($numero2)) {
        $error = "Por favor, complete ambos campos numéricos.";
    } elseif (!is_numeric($numero1) || !is_numeric($numero2)) {
        $error = "Por favor, ingrese valores numéricos válidos.";
    } else {
        $num1 = floatval($numero1);
        $num2 = floatval($numero2);
        
        switch ($operacion) {
            case "suma":
                $resultado = $num1 + $num2;
                $simbolo = "+";
                $nombre_operacion = "Suma";
                break;
            case "resta":
                $resultado = $num1 - $num2;
                $simbolo = "-";
                $nombre_operacion = "Resta";
                break;
            case "multiplicacion":
                $resultado = $num1 * $num2;
                $simbolo = "×";
                $nombre_operacion = "Multiplicación";
                break;
            default:
                $error = "Por favor, seleccione una operación.";
        }
        
        if ($resultado !== "") {
            $resultado = number_format($resultado, 2);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema #6 - Calculadora UI/UX</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <a href="Laboratorio.php" class="btn btn-volver">← Volver al menú principal</a>
        
        <div class="main-header">
            <h1>Problema #6</h1>
            <p>Calculadora con UI/UX</p>
        </div>

        <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; margin: 0 auto;">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Primer número</label>
                    <input type="text" name="numero1" value="<?php echo htmlspecialchars($numero1); ?>" placeholder="Ejemplo: 10, 15.5, 20">
                </div>
                
                <div class="form-group">
                    <label> Segundo número</label>
                    <input type="text" name="numero2" value="<?php echo htmlspecialchars($numero2); ?>" placeholder="Ejemplo: 5, 3.2, 8">
                </div>
                
                <div class="buttons-group">
                    <button type="submit" name="operacion" value="suma" class="operation-btn <?php echo ($operacion == 'suma') ? 'active' : ''; ?>">
                        ➕ Suma
                    </button>
                    <button type="submit" name="operacion" value="resta" class="operation-btn <?php echo ($operacion == 'resta') ? 'active' : ''; ?>">
                        ➖ Resta
                    </button>
                    <button type="submit" name="operacion" value="multiplicacion" class="operation-btn <?php echo ($operacion == 'multiplicacion') ? 'active' : ''; ?>">
                        ✖️ Multiplicación
                    </button>
                </div>
                
                <button type="submit" class="btn btn-calcular">= Calcular</button>
            </form>
            
            <?php if ($resultado !== "" && !$error): ?>
                <div class="result">
                    <div class="result-label">RESULTADO</div>
                    <div class="result-value">
                        <?php echo number_format($num1, 2) . " " . $simbolo . " " . number_format($num2, 2) . " = " . $resultado; ?>
                    </div>
                    <div style="margin-top: 10px; color: #667eea;">
                        <?php echo $nombre_operacion; ?> realizada
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error"> <?php echo $error; ?></div>
            <?php endif; ?>
            
        
        </div>
    </div>
</body>
</html>