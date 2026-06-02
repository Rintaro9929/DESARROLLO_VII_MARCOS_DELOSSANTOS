<?php
session_start();

// Ruta correcta con __DIR__
require_once(__DIR__ . "/../classes/CSRFProtection.php");

// Generar token CSRF si no existe
if (!isset($_SESSION['csrf_token'])) {
    // Método manual para generar token (por si la clase falla)
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
    <title>Registro de Usuario - Sistema con 2FA</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 550px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .info {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Registro de Usuario</h1>
        <div class="info">
            ℹ️ Después del registro, deberás configurar la autenticación de dos factores (2FA) 
            escaneando un código QR con <strong>Google Authenticator</strong>.
        </div>
        <?php include("registrese_form.php"); ?>
    </div>
</body>
</html>