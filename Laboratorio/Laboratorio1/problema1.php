<?php
$radio = "";
$area = "";
$perimetro = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['radio']) && !empty($_POST['radio'])) {
        $radio = trim($_POST['radio']);
        
        if (is_numeric($radio)) {
            $radio = floatval($radio);
            
            if ($radio > 0) {
                $pi = 3.14159265359;
                $area = $pi * ($radio * $radio);
                $area = number_format($area, 2);
                $perimetro = 2 * $pi * $radio;
                $perimetro = number_format($perimetro, 2);
            } else {
                $error = "Por favor, ingrese un radio mayor que cero.";
            }
        } else {
            $error = "Por favor, ingrese un número válido.";
        }
    } else {
        $error = "Por favor, ingrese el valor del radio.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema #1 - Área y Perímetro del Círculo</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <a href="Laboratorio.php" class="btn btn-volver">← Volver al menú principal</a>
        
        <div class="main-header">
            <h1>Problema #1</h1>
            <p>Área y Perímetro de un Círculo</p>
        </div>

        <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; margin: 0 auto;">
            <div style="text-align: center; font-size: 50px; margin-bottom: 20px;"></div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Ingrese el radio del círculo:</label>
                    <input type="text" name="radio" value="<?php echo htmlspecialchars($radio); ?>" placeholder="Ejemplo: 5, 7.5, 10">
                </div>
                <button type="submit" class="btn btn-calcular">Calcular</button>
            </form>
            
            <?php if ($area && $perimetro): ?>
                <div class="resultados">
                    <div class="resultado-card area">
                        <h3>ÁREA</h3>
                        <p><?php echo $area; ?> cm²</p>
                    </div>
                    <div class="resultado-card perimetro">
                        <h3>PERÍMETRO</h3>
                        <p><?php echo $perimetro; ?> cm</p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>