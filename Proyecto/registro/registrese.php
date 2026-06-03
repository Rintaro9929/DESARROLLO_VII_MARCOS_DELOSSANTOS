<?php
session_start();
require_once(__DIR__ . "/../classes/CSRFProtection.php");

$token = CSRFProtection::generarToken();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo $token; ?>">
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
        fieldset {
            margin: 8px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        legend {
            font-weight: bold;
            color: #333;
            padding: 0 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"] {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        button[type="reset"] {
            background: #6c757d;
            color: white;
        }
        label.error {
            color: red;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }
        input.error {
            border-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Registro de Usuario</h1>
        <div class="info">
            ℹ️ Después del registro, configura la autenticación 2FA escaneando el código QR con Google Authenticator.
        </div>
        <?php include("registrese_form.php"); ?>
    </div>
</body>
</html>