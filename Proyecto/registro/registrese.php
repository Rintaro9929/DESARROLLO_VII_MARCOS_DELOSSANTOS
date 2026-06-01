<?php
session_start();
require_once("../classes/CSRFProtection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php
    // Safely obtain CSRF token only if the class and method are available
    $csrfToken = '';
    if (class_exists('CSRFProtection') && method_exists('CSRFProtection', 'obtenerToken')) {
        $csrfToken = CSRFProtection::obtenerToken();
    }
    ?>
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
    <title>Registro de Usuario - Sistema con 2FA</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .info {
            background: #e8f4f8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Registro de Usuario</h1>
        <div class="info">
            ℹ️ Después del registro, deberás configurar la autenticación de dos factores (2FA) 
            escaneando un código QR con Google Authenticator.
        </div>
        <?php include("registrese_form.php"); ?>
    </div>
</body>
</html>