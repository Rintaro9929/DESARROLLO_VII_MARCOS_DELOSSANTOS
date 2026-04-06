<?php
$autor1 = "Marcos De Los Santos";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema #4 - Hola Mundo con Variables</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <a href="Laboratorio.php" class="btn btn-volver">← Volver al menú principal</a>
        
        <div class="main-header">
            <h1>Problema #4</h1>
            <p>Hola Mundo con Variables</p>
        </div>
        
        <div style="background: white; border-radius: 15px; padding: 40px; text-align: center; max-width: 600px; margin: 0 auto;">
            <h1 style="color: #667eea; margin-bottom: 20px;">¡Hola Mundo!</h1>
            <p style="font-size: 18px; color: #555;">Esta página web dinámica fue creada por <strong><?php echo $autor1; ?></strong> usando PHP.</p>
    </div>
</body>
</html>