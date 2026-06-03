<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privilegios de Usuario - Base de Datos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 15px;
            padding: 35px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .privilege-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid #28a745;
        }
        .privilege-card h3 {
            color: #28a745;
            margin-bottom: 15px;
        }
        .grant-item {
            background: #e9ecef;
            padding: 10px 15px;
            margin: 8px 0;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            word-break: break-all;
        }
        .command {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 20px 0;
            overflow-x: auto;
        }
        .badge {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-right: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #999;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Seguridad de Base de Datos</h1>
        <div class="subtitle">
            Usuario con privilegios mínimos - Principio de Menor Privilegio
        </div>

        <?php
        try {
            // Conectar con root para ver los privilegios
            $pdo = new PDO('mysql:host=localhost;port=3307;dbname=expedientes;charset=utf8mb4', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Obtener privilegios del usuario_lab
            $stmt = $pdo->query("SHOW GRANTS FOR 'usuario_lab'@'localhost'");
            $grants = $stmt->fetchAll(PDO::FETCH_COLUMN);
            ?>
            
            <div class="privilege-card">
                <h3>👤 Usuario de Aplicación</h3>
                <p><span class="badge">Usuario</span> <strong>usuario_lab@localhost</strong></p>
                <p><span class="badge">Base de Datos</span> <strong>expedientes</strong></p>
                <p><span class="badge">Permisos</span> SELECT, INSERT, UPDATE (solo en tablas necesarias)</p>
                <p><span class="badge">Puerto</span> <strong>3307</strong></p>
            </div>

            <div class="privilege-card">
                <h3>📋 Privilegios Concedidos</h3>
                <?php foreach ($grants as $grant): ?>
                    <div class="grant-item"><?php echo htmlspecialchars($grant); ?></div>
                <?php endforeach; ?>
            </div>

            <h3>💻 Comando para verificar privilegios</h3>
            <div class="command">
                SHOW GRANTS FOR 'usuario_lab'@'localhost';
            </div>

            <div class="privilege-card">
                <h3>✅ Principios de Seguridad Aplicados</h3>
                <ul style="margin: 10px 0 0 20px; line-height: 1.6;">
                    <li>✓ No se usa el usuario <strong>root</strong> en la aplicación</li>
                    <li>✓ Usuario dedicado <strong>usuario_lab</strong> con permisos limitados</li>
                    <li>✓ Solo permisos necesarios: SELECT, INSERT, UPDATE</li>
                    <li>✓ Sin permisos de DROP, CREATE, DELETE innecesarios</li>
                    <li>✓ Conexión a MySQL en puerto 3307</li>
                </ul>
            </div>

            <?php
        } catch (PDOException $e) {
            echo '<div class="error">';
            echo '<strong>❌ Error al obtener privilegios:</strong><br>';
            echo 'Verifica que MySQL esté corriendo en el puerto 3307<br>';
            echo 'Usuario root con contraseña vacía<br>';
            echo 'Detalle técnico: ' . htmlspecialchars($e->getMessage());
            echo '</div>';
        }
        ?>

        <div style="text-align: center;">
            <a href="index.php" class="btn">← Volver al Inicio</a>
            <a href="dashboard.php" class="btn">📊 Ir al Dashboard</a>
        </div>
        
        <div class="footer">
            Laboratorio de Autenticación 2FA - Desarrollo Web VII<br>
            Universidad Tecnológica de Panamá
        </div>
    </div>
</body>
</html>