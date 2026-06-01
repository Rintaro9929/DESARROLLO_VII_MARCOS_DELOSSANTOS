<?php
// Archivo: comunes/cabecera4.php
// Cabecera del sitio web
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Autenticación con 2FA</title>
    
    <!-- Estilos CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }
        
        /* Barra de navegación superior */
        .top-navbar {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .logo span {
            font-size: 1.8rem;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: #e94560;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* Contenedor principal */
        .main-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        /* Mensajes de alerta */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        /* Botones */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        /* Footer */
        .footer {
            background: #1a1a2e;
            color: #888;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            font-size: 14px;
        }
        
        /* Tarjetas */
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            font-weight: bold;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Formularios */
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        /* Grid responsivo */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }
        
        .col {
            flex: 1;
            padding: 10px;
        }
        
        @media (max-width: 768px) {
            .top-navbar {
                flex-direction: column;
                gap: 10px;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .row {
                flex-direction: column;
            }
        }
    </style>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- jQuery Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
</head>
<body>
    <div class="top-navbar">
        <div class="logo">
            <span>🔐</span>
            <h1>Sistema de Autenticación 2FA</h1>
        </div>
        
        <div class="nav-links">
            <a href="../index.php">🏠 Inicio</a>
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true): ?>
                <a href="../dashboard.php">📊 Dashboard</a>
                <a href="../login/logout.php">🚪 Cerrar Sesión</a>
            <?php else: ?>
                <a href="../login/login.php">🔑 Iniciar Sesión</a>
                <a href="../registro/registrese.php">📝 Registrarse</a>
            <?php endif; ?>
        </div>
        
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true): ?>
        <div class="user-info">
            <span>👋 Hola, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Usuario'); ?></span>
            <div class="user-avatar">
                <?php echo substr(($_SESSION['user_name'] ?? 'U'), 0, 1); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="main-container">