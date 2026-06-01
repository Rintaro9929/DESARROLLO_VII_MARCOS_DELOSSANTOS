<?php
session_start();
require_once("classes/CSRFProtection.php");

// Verificar autenticación completa (login + 2FA)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['2fa_verified']) || $_SESSION['2fa_verified'] !== true) {
    header("Location: login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Seguro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .logout-btn {
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        .success-icon {
            font-size: 48px;
            text-align: center;
            color: #28a745;
        }
        h2 {
            color: #333;
        }
        .info-box {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🏠 Sistema con 2FA</h2>
        <a href="login/logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
    
    <div class="container">
        <div class="card">
            <div class="success-icon">✅</div>
            <h2>¡Bienvenido(a), <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
            <p>Has iniciado sesión correctamente con autenticación de dos factores (2FA).</p>
            
            <div class="info-box">
                <strong>📋 Información de tu sesión:</strong><br>
                📧 Correo: <?php echo htmlspecialchars($_SESSION['user_email']); ?><br>
                🆔 ID de usuario: <?php echo htmlspecialchars($_SESSION['user_id']); ?><br>
                🔐 Autenticación 2FA: <span style="color:green;">✓ Verificada</span><br>
                🌐 IP: <?php echo $_SERVER['REMOTE_ADDR']; ?>
            </div>
        </div>
    </div>
</body>
</html>