<?php
// procesador_frases
include 'operaciones_cadenas.php';

//Aqui definimos las frases del ejemplo

$frases = [
    "tres por tres es nueve",
    "PHP es un lenguaje de programación",
    "la práctica hace al maestro",
    "hola mundo desde PHP"
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesador de Frases</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .frase-original {
            font-style: italic;
            color: #7f8c8d;
        }
        .frase-capitalizada {
            font-weight: bold;
            color: #27ae60;
        }
        .conteo-palabras {
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Procesador de Frases</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Frase Original</th>
                    <th>Frase Capitalizada</th>
                    <th>Conteo de Palabras</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($frases as $frase): ?>
                <tr>
                    <td class="frase-original"><?php echo htmlspecialchars($frase); ?></td>
                    <td class="frase-capitalizada"><?php echo htmlspecialchars(capitalizar_palabras($frase)); ?></td>
                    <td class="conteo-palabras">
                        <?php 
                        $conteo = contar_palabras_repetidas($frase);
                        if (count($conteo) > 0) {
                            echo "<ul>";
                            foreach ($conteo as $palabra => $cantidad) {
                                echo "<li><strong>" . htmlspecialchars($palabra) . "</strong>: $cantidad</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "No hay palabras para contar";
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>