<?php
// gestionar_membresias.php
include 'funciones_gimnasio.php';


$membresias = [
    'basica' => 80,
    'premium' => 120,
    'vip' => 180,
    'familiar' => 250,
    'corporativa' => 300
];


$miembros = [
    "Juan Perez" => ['tipo' => 'premium', 'antiguedad' => 15],
    "Ana García" => ['tipo' => 'basica', 'antiguedad' => 2],
    "Carlos López" => ['tipo' => 'vip', 'antiguedad' => 38],
    "María Rodríguez" => ['tipo' => 'familiar', 'antiguedad' => 8],
    "Luis Martínez" => ['tipo' => 'corporativa', 'antiguedad' => 18]
];

$resultados = [];
foreach ($miembros as $nombre => $datos) {
    $tipo = $datos['tipo'];
    $antiguedad = $datos['antiguedad'];
    $precio_base = $membresias[$tipo];
    
    $descuento_porcentaje = calcular_promocion($antiguedad);
    $seguro_medico = calcular_seguro_medico($tipo);
    $cuota_final = calcular_cuota_final($precio_base, $descuento_porcentaje, $seguro_medico);
    
    $resultados[$nombre] = [
        'tipo' => $tipo,
        'antiguedad' => $antiguedad,
        'precio_base' => $precio_base,
        'descuento_porcentaje' => $descuento_porcentaje,
        'descuento_monto' => $precio_base * ($descuento_porcentaje / 100),
        'seguro_medico' => $seguro_medico,
        'cuota_final' => $cuota_final
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Membresías</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: #333;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #7f8c8d;
            font-size: 1.2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 15px 18px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9f7fe;
            transition: background-color 0.3s;
        }
        .miembro {
            text-align: left;
            font-weight: bold;
            color: #2c3e50;
        }
        .tipo-membresia {
            font-weight: bold;
            text-transform: capitalize;
        }
        .precio {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
        .descuento {
            color: #27ae60;
        }
        .seguro {
            color: #e74c3c;
        }
        .cuota-final {
            font-weight: bold;
            color: #2980b9;
            font-size: 1.1rem;
        }
        .resumen {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 30px;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 250px;
        }
        .card h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        .card ul {
            list-style-type: none;
        }
        .card li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .card li:last-child {
            border-bottom: none;
        }
        .precios-membresias {
            background-color: #e8f4fc;
        }
        .totales {
            background-color: #e6f7ee;
        }
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
            .resumen {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Gestión de Membresías</h1>
            <p class="subtitle">Sistema de cálculo de cuotas para miembros del gimnasio</p>
        </header>
        
        <table>
            <thead>
                <tr>
                    <th>Miembro</th>
                    <th>Tipo de Membresía</th>
                    <th>Antigüedad (años)</th>
                    <th>Precio Base ($)</th>
                    <th>Descuento (%)</th>
                    <th>Descuento ($)</th>
                    <th>Seguro Médico ($)</th>
                    <th>Cuota Final ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $nombre => $datos): ?>
                <tr>
                    <td class="miembro"><?php echo htmlspecialchars($nombre); ?></td>
                    <td class="tipo-membresia"><?php echo htmlspecialchars($datos['tipo']); ?></td>
                    <td><?php echo $datos['antiguedad']; ?></td>
                    <td class="precio"><?php echo number_format($datos['precio_base'], 2); ?></td>
                    <td class="descuento"><?php echo $datos['descuento_porcentaje']; ?>%</td>
                    <td class="descuento"><?php echo number_format($datos['descuento_monto'], 2); ?></td>
                    <td class="seguro"><?php echo number_format($datos['seguro_medico'], 2); ?></td>
                    <td class="cuota-final"><?php echo number_format($datos['cuota_final'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="resumen">
            <div class="card precios-membresias">
                <h3>Precios de Membresías</h3>
                <ul>
                    <?php foreach ($membresias as $tipo => $precio): ?>
                    <li><strong><?php echo ucfirst($tipo); ?>:</strong> $<?php echo number_format($precio, 2); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="card totales">
                <h3>Resumen de Ingresos</h3>
                <?php
                $total_base = 0;
                $total_descuentos = 0;
                $total_seguros = 0;
                $total_final = 0;
                
                foreach ($resultados as $datos) {
                    $total_base += $datos['precio_base'];
                    $total_descuentos += $datos['descuento_monto'];
                    $total_seguros += $datos['seguro_medico'];
                    $total_final += $datos['cuota_final'];
                }
                ?>
                <ul>
                    <li><strong>Total Precio Base:</strong> $<?php echo number_format($total_base, 2); ?></li>
                    <li><strong>Total Descuentos:</strong> $<?php echo number_format($total_descuentos, 2); ?></li>
                    <li><strong>Total Seguros Médicos:</strong> $<?php echo number_format($total_seguros, 2); ?></li>
                    <li><strong>Total Ingresos:</strong> $<?php echo number_format($total_final, 2); ?></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>