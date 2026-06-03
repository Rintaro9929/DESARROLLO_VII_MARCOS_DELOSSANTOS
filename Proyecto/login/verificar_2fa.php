<?php
session_start();
require_once(__DIR__ . "/../classes/CSRFProtection.php");
require_once(__DIR__ . "/../vendor/autoload.php");

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

if (!isset($_SESSION['user_id']) || !isset($_SESSION['2fa_pending'])) {
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true) {
    header("Location: ../dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Error de seguridad");
    }
    
    $codigo = $_POST['codigo_2fa'] ?? '';
    $secret = $_SESSION['secret_2fa'] ?? '';
    
    if (empty($secret)) {
        $error = "Error de configuración de seguridad";
    } else {
        $g = new GoogleAuthenticator();
        if ($g->checkCode($secret, $codigo)) {
            $_SESSION['2fa_verified'] = true;
            unset($_SESSION['2fa_pending']);
            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "❌ Código incorrecto";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar 2FA</title>
    <style>
        body{font-family:Arial;background:linear-gradient(135deg,#667eea,#764ba2);min-height:100vh;display:flex;justify-content:center;align-items:center}
        .container{background:#fff;padding:40px;border-radius:10px;text-align:center;width:400px}
        input{width:100%;padding:15px;font-size:24px;text-align:center;letter-spacing:5px;border:2px solid #ddd;border-radius:8px;font-family:monospace}
        button{width:100%;padding:12px;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border:none;border-radius:5px;margin-top:15px;cursor:pointer}
        .error{background:#fee;color:#c33;padding:10px;border-radius:5px;margin-bottom:20px}
        .back-link{margin-top:20px}
        .back-link a{color:#667eea;text-decoration:none}
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 Autenticación 2FA</h2>
        <p>Ingresa el código de 6 dígitos de Google Authenticator</p>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
            <input type="text" name="codigo_2fa" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required autofocus>
            <button type="submit">Verificar y Acceder</button>
        </form>
        <div class="back-link"><a href="login.php">← Volver</a></div>
    </div>
</body>
</html>