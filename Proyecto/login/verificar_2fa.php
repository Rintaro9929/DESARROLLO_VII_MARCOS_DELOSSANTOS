<?php
session_start();
require_once("../classes/CSRFProtection.php");

// Verificar que el usuario ha pasado el primer factor
if (!isset($_SESSION['user_id']) || !isset($_SESSION['2fa_pending'])) {
    header("Location: login.php");
    exit;
}

// Si ya verificó 2FA, redirigir a dashboard
if (isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true) {
    header("Location: ../dashboard.php");
    exit;
}

require_once("../vendor/autoload.php");
use Sonata\GoogleAuthenticator\GoogleAuthenticator;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRFProtection::verificarFormulario();
    
    $codigo_2fa = $_POST['codigo_2fa'] ?? '';
    $secret = $_SESSION['secret_2fa'] ?? '';
    
    if (empty($secret)) {
        $error = "Error de configuración de seguridad. Contacte al administrador.";
    } else {
        $g = new GoogleAuthenticator();
        
        if ($g->checkCode($secret, $codigo_2fa)) {
            // Código 2FA correcto
            $_SESSION['2fa_verified'] = true;
            unset($_SESSION['2fa_pending']);
            
            // Regenerar token CSRF por seguridad
            CSRFProtection::regenerarToken();
            
            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "❌ Código de verificación incorrecto. Por favor, intente nuevamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Dos Factores - 2FA</title>
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
        }
        
        .verification-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 400px;
            padding: 40px;
            text-align: center;
        }
        
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .code-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 15px;
            font-size: 24px;
            text-align: center;
            letter-spacing: 5px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-family: monospace;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        
        button:hover {
            transform: scale(1.02);
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .back-link {
            margin-top: 20px;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="code-icon">🔐</div>
        <h2>Autenticación de Dos Factores</h2>
        <p class="subtitle">Ingresa el código de 6 dígitos de Google Authenticator</p>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <?php echo CSRFProtection::campoHidden(); ?>
            
            <div class="form-group">
                <input type="text" name="codigo_2fa" maxlength="6" pattern="[0-9]{6}" 
                       placeholder="000000" required autofocus>
            </div>
            
            <button type="submit">Verificar y Acceder</button>
        </form>
        
        <div class="back-link">
            <a href="login.php">← Volver al inicio de sesión</a>
        </div>
    </div>
</body>
</html>