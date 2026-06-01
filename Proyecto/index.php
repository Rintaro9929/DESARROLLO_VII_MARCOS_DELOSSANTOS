<?php
session_start();
// CORREGIDO: Agregar la ruta correcta a CSRFProtection
$csrfFile = __DIR__ . "/classes/CSRFProtection.php";
if (file_exists($csrfFile)) {
    require_once $csrfFile;
} else {
    // Ruta alternativa si se ejecuta desde un subdirectorio
    require_once __DIR__ . "/../classes/CSRFProtection.php";
}
require_once(__DIR__ . "/comunes/loginfunciones.php");

// Inicializar CSRF si es necesario
if (!isset($_SESSION['csrf_token']) && class_exists('CSRFProtection')) {
    if (method_exists('CSRFProtection', 'generarToken')) {
        CSRFProtection::generarToken();
    } elseif (method_exists('CSRFProtection', 'generateToken')) {
        CSRFProtection::generateToken();
    } else {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

$csrfToken = '';
if (class_exists('CSRFProtection') && method_exists('CSRFProtection', 'obtenerToken')) {
    $csrfToken = CSRFProtection::obtenerToken();
} elseif (isset($_SESSION['csrf_token'])) {
    $csrfToken = $_SESSION['csrf_token'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
    <title>Inicio - Sistema de Autenticación con 2FA</title>
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
        }
        
        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .hero-content {
            background: white;
            border-radius: 20px;
            padding: 50px;
            max-width: 800px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .hero-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
        }
        
        .description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }
        
        .feature {
            flex: 1;
            min-width: 200px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        
        .feature-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        
        .feature h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .feature p {
            color: #666;
            font-size: 14px;
        }
        
        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .status-authenticated {
            background: #d4edda;
            color: #155724;
        }
        
        .status-guest {
            background: #e2e3e5;
            color: #383d41;
        }
        
        @media (max-width: 768px) {
            .hero-content {
                padding: 30px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            .features {
                flex-direction: column;
            }
            
            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="hero-content">
            <div class="hero-icon">🔐</div>
            
            <?php if (isset($_SESSION['user_id']) && isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true): ?>
                <div class="status-badge status-authenticated">
                    ✅ Sesión activa - Bienvenido <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </div>
                <h1>¡Bienvenido al Sistema!</h1>
                <p class="description">
                    Has iniciado sesión correctamente con autenticación de dos factores.
                    Tu cuenta está protegida con el más alto nivel de seguridad.
                </p>
                <div class="buttons">
                    <a href="dashboard.php" class="btn btn-primary">📊 Ir al Dashboard</a>
                    <a href="login/logout.php" class="btn btn-secondary">🚪 Cerrar Sesión</a>
                </div>
            <?php else: ?>
                <div class="status-badge status-guest">
                    👋 Modo Invitado
                </div>
                <h1>Sistema de Autenticación con Doble Factor (2FA)</h1>
                <p class="description">
                    Un sistema de autenticación seguro que combina contraseña tradicional con 
                    verificación de dos factores usando Google Authenticator. Protege tu cuenta 
                    contra accesos no autorizados.
                </p>
                
                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">🔑</div>
                        <h3>Login Seguro</h3>
                        <p>Autenticación con contraseñas hasheadas (BCRYPT)</p>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📱</div>
                        <h3>2FA con Google Authenticator</h3>
                        <p>Códigos temporales que cambian cada 30 segundos</p>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📊</div>
                        <h3>Auditoría</h3>
                        <p>Registro de todos los intentos de inicio de sesión</p>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🛡️</div>
                        <h3>Protección CSRF</h3>
                        <p>Tokens anti-falsificación de peticiones</p>
                    </div>
                </div>
                
                <div class="buttons">
                    <a href="login/login.php" class="btn btn-primary">🔑 Iniciar Sesión</a>
                    <a href="registro/registrese.php" class="btn btn-secondary">📝 Registrarse</a>
                </div>
            <?php endif; ?>
            
            <p style="margin-top: 30px; font-size: 12px; color: #999;">
                Universidad Tecnológica de Panamá - Facultad de Ingeniería en Sistemas<br>
                Desarrollo de Software VII - Laboratorio de Autenticación 2FA
            </p>
        </div>
    </div>
</body>
</html>