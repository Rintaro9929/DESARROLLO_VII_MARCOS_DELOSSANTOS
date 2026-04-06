<?php
$pulgadas = "";
$centimetros = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pulgadas']) && !empty($_POST['pulgadas'])) {
        $pulgadas = trim($_POST['pulgadas']);
        
        if (is_numeric($pulgadas)) {
            $centimetros = $pulgadas * 2.54;
            $centimetros = number_format($centimetros, 2);
        } else {
            $error = "Por favor, ingrese un número válido.";
        }
    } else {
        $error = "Por favor, ingrese el valor en pulgadas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema #2 - Convertir Pulgadas a Centímetros</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <a href="Laboratorio.php" class="btn btn-volver">← Volver al menú principal</a>
        
        <div class="main-header">
            <h1>Problema #2</h1>
            <p>Convertir Pulgadas a Centímetros</p>
        </div>

        <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; margin: 0 auto;">
            <div class="info">1 pulgada = 2.54 centímetros</div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Ingrese las pulgadas:</label>
                    <input type="text" name="pulgadas" value="<?php echo htmlspecialchars($pulgadas); ?>" placeholder="Ejemplo: 10, 15.5, 20">
                </div>
                <button type="submit" class="btn btn-calcular">Convertir</button>
            </form>
            
            <?php if ($centimetros): ?>
                <div class="result">
                    <div class="result-label">RESULTADO</div>
                    <div class="result-value">
                        <?php echo $pulgadas; ?> pulgadas = <?php echo $centimetros; ?> centímetros
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