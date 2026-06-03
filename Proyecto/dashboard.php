<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['2fa_verified']) || $_SESSION['2fa_verified'] !== true) {
    header("Location: login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema Seguro</title>
    <style>
        body{font-family:'Segoe UI',sans-serif;background:#f4f4f4;margin:0;padding:0}
        .navbar{background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;padding:15px 30px;display:flex;justify-content:space-between;align-items:center}
        .container{max-width:800px;margin:40px auto;padding:20px}
        .card{background:#fff;border-radius:10px;padding:30px;box-shadow:0 5px 15px rgba(0,0,0,0.1)}
        .logout-btn{background:rgba(255,255,255,0.2);padding:8px 20px;border-radius:5px;color:#fff;text-decoration:none}
        .success-icon{font-size:48px;text-align:center;color:#28a745}
        h2{color:#333}
        .info-box{background:#e8f4f8;padding:15px;border-radius:8px;margin-top:20px}
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🏠 Sistema con 2FA</h2>
        <a href="login/logout.php" class="logout-btn">Cerrar Sesión</a>
    </div>
    <div class="container">
      <div class="card">
    <h3>📊 Información de la sesión</h3>
    <p>✅ Autenticación 2FA verificada</p>
    <p>📅 Fecha de inicio: <?php echo date('d/m/Y H:i:s'); ?></p>
    <p>🌐 IP: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
</div>