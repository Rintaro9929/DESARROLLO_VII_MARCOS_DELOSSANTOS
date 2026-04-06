<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema #3 - Verificar Instalación de PHP</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <a href="Laboratorio.php" class="btn btn-volver">← Volver al menú principal</a>
        
        <div class="main-header">
            <h1>Problema #3</h1>
            <p>Verificar Instalación de PHP</p>
        </div>
        
        <div style="background: white; border-radius: 15px; padding: 20px; overflow-x: auto;">
            <?php phpinfo(); ?>
        </div>
    </div>
</body>
</html>