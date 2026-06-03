<?php
session_start();
require_once(__DIR__ . "/../classes/myConexionPDO.php");
require_once(__DIR__ . "/../classes/CSRFProtection.php");

// Verificar CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Error de seguridad");
    }
}

$pdo = new mod_db();
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

try {
    $sql = "SELECT * FROM usuarios WHERE Correo = :email";
    $stmt = $pdo->executeQuery($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_OBJ);
    
    if ($usuario && password_verify($password, $usuario->HashMagic)) {
        $_SESSION['user_id'] = $usuario->id;
        $_SESSION['user_email'] = $usuario->Correo;
        $_SESSION['user_name'] = $usuario->Nombre . ' ' . $usuario->Apellido;
        $_SESSION['2fa_pending'] = true;
        $_SESSION['secret_2fa'] = $usuario->secret_2fa;
        
        // Registrar intento exitoso
        $audit = $pdo->executeQuery("INSERT INTO login_audit (username, status, ip_address, user_agent) VALUES (:email, 'exitoso', :ip, :ua)");
        $audit->bindParam(':email', $email);
        $audit->bindParam(':ip', $ip);
        $audit->bindParam(':ua', $user_agent);
        $audit->execute();
        
        header("Location: verificar_2fa.php");
        exit;
    } else {
        $audit = $pdo->executeQuery("INSERT INTO login_audit (username, status, ip_address, user_agent) VALUES (:email, 'fallido', :ip, :ua)");
        $audit->bindParam(':email', $email);
        $audit->bindParam(':ip', $ip);
        $audit->bindParam(':ua', $user_agent);
        $audit->execute();
        
        $_SESSION['login_error'] = "Credenciales incorrectas";
        header("Location: login.php");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['login_error'] = "Error en el sistema";
    header("Location: login.php");
    exit;
}
?>