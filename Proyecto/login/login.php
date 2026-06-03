<?php
session_start();
require_once(__DIR__ . "/../classes/CSRFProtection.php");

CSRFProtection::generarToken();

if (isset($_SESSION['user_id']) && isset($_SESSION['2fa_verified']) && $_SESSION['2fa_verified'] === true) {
    header("Location: ../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión - Sistema 2FA</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#667eea,#764ba2);min-height:100vh;display:flex;justify-content:center;align-items:center}
        .login-container{background:#fff;border-radius:10px;box-shadow:0 15px 35px rgba(0,0,0,0.2);width:400px;padding:40px}
        h2{text-align:center;margin-bottom:30px;color:#333}
        .form-group{margin-bottom:20px}
        label{display:block;margin-bottom:5px;color:#666}
        input{width:100%;padding:12px;border:1px solid #ddd;border-radius:5px;font-size:16px}
        input:focus{outline:none;border-color:#667eea}
        button{width:100%;padding:12px;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border:none;border-radius:5px;font-size:16px;cursor:pointer}
        button:hover{transform:scale(1.02)}
        .register-link{text-align:center;margin-top:20px}
        .register-link a{color:#667eea;text-decoration:none}
        .error{background:#fee;color:#c33;padding:10px;border-radius:5px;margin-bottom:20px;text-align:center}
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔐 Iniciar Sesión</h2>
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="error"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></div>
        <?php endif; ?>
        <form method="POST" action="procesar_login.php">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label>📧 Correo Electrónico</label>
                <input type="text" name="email" required autofocus>
            </div>
            <div class="form-group">
                <label>🔒 Contraseña</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <div class="register-link">¿No tienes cuenta? <a href="../registro/registrese.php">Regístrate aquí</a></div>
    </div>
</body>
</html>