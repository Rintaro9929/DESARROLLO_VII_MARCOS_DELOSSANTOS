<?php
session_start();
require_once __DIR__ . '/../classes/myConexionPDO.php';

$csrfFile = __DIR__ . '/../classes/CSRFProtection.php';
if (file_exists($csrfFile)) {
    require_once $csrfFile;
}

if (!class_exists('CSRFProtection', false)) {
    class CSRFProtection {
        public static function verificarFormulario(): void {
            // Implementación de respaldo cuando no hay clase CSRF disponible.
        }
    }
}

CSRFProtection::verificarFormulario();

$pdo = new mod_db();
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Registrar intento de login en auditoría
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

try {
    // Buscar usuario por email
    $sql = "SELECT * FROM usuarios WHERE Correo = :email";
    $stmt = $pdo->executeQuery($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_OBJ);
    
    $status = 'fallido';
    
    if ($usuario && password_verify($password, $usuario->HashMagic)) {
        $status = 'exitoso';
        
        // Guardar en sesión los datos del usuario
        $_SESSION['user_id'] = $usuario->id;
        $_SESSION['user_email'] = $usuario->Correo;
        $_SESSION['user_name'] = $usuario->Nombre . ' ' . $usuario->Apellido;
        $_SESSION['2fa_pending'] = true;  // Marcar que necesita 2FA
        $_SESSION['secret_2fa'] = $usuario->secret_2fa;
        
        // Registrar en auditoría
        $auditSql = "INSERT INTO login_audit (username, status, ip_address, user_agent, login_time) 
                     VALUES (:email, :status, :ip, :ua, NOW())";
        $auditStmt = $pdo->executeQuery($auditSql);
        $auditStmt->bindParam(':email', $email);
        $auditStmt->bindParam(':status', $status);
        $auditStmt->bindParam(':ip', $ip);
        $auditStmt->bindParam(':ua', $user_agent);
        $auditStmt->execute();
        
        // Redirigir a verificación 2FA
        header("Location: verificar_2fa.php");
        exit;
    } else {
        // Registrar intento fallido
        $auditSql = "INSERT INTO login_audit (username, status, ip_address, user_agent, login_time) 
                     VALUES (:email, :status, :ip, :ua, NOW())";
        $auditStmt = $pdo->executeQuery($auditSql);
        $auditStmt->bindParam(':email', $email);
        $auditStmt->bindParam(':status', $status);
        $auditStmt->bindParam(':ip', $ip);
        $auditStmt->bindParam(':ua', $user_agent);
        $auditStmt->execute();
        
        $_SESSION['login_error'] = "Credenciales incorrectas";
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    error_log("Error en login: " . $e->getMessage());
    $_SESSION['login_error'] = "Error en el sistema. Intente más tarde.";
    header("Location: login.php");
    exit;
}
?>