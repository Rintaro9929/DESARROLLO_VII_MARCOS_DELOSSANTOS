<?php
// Archivo: comunes/loginfunciones.php
// Funciones auxiliares para el sistema de login y autenticación

/**
 * Verificar si el usuario está autenticado completamente (incluyendo 2FA)
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['2fa_verified']) && 
           $_SESSION['2fa_verified'] === true;
}

/**
 * Verificar si el usuario ha pasado el primer factor (contraseña) pero no el 2FA
 */
function isPending2FA() {
    return isset($_SESSION['user_id']) && 
           isset($_SESSION['2fa_pending']) && 
           $_SESSION['2fa_pending'] === true;
}

/**
 * Redirigir si no está autenticado
 */
function requireAuth() {
    if (!isAuthenticated()) {
        if (isPending2FA()) {
            header("Location: login/verificar_2fa.php");
        } else {
            header("Location: login/login.php");
        }
        exit;
    }
}

/**
 * Redirigir si ya está autenticado
 */
function requireGuest() {
    if (isAuthenticated()) {
        header("Location: dashboard.php");
        exit;
    }
}

/**
 * Registrar intento de login en la base de datos
 */
function registrarIntentoLogin($pdo, $email, $status, $ip, $user_agent) {
    try {
        $sql = "INSERT INTO login_audit (username, status, ip_address, user_agent, login_time) 
                VALUES (:email, :status, :ip, :ua, NOW())";
        $stmt = $pdo->executeQuery($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':ip', $ip);
        $stmt->bindParam(':ua', $user_agent);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error registrando intento de login: " . $e->getMessage());
        return false;
    }
}

/**
 * Obtener el número de intentos fallidos de un usuario en los últimos minutos
 */
function getFailedAttempts($pdo, $email, $minutes = 15) {
    try {
        $sql = "SELECT COUNT(*) as total FROM login_audit 
                WHERE username = :email 
                AND status = 'fallido' 
                AND login_time > DATE_SUB(NOW(), INTERVAL :minutes MINUTE)";
        $stmt = $pdo->executeQuery($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':minutes', $minutes);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result ? $result->total : 0;
    } catch (PDOException $e) {
        error_log("Error obteniendo intentos fallidos: " . $e->getMessage());
        return 0;
    }
}

/**
 * Generar token de recuperación para 2FA (en caso de pérdida del dispositivo)
 */
function generarTokenRecuperacion($longitud = 32) {
    return bin2hex(random_bytes($longitud));
}

/**
 * Sanitizar entrada para prevenir XSS
 */
function sanitizarOutput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

/**
 * Verificar si la contraseña cumple con los requisitos de seguridad
 */
function validarFortalezaPassword($password) {
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = "La contraseña debe tener al menos 8 caracteres";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "La contraseña debe tener al menos una mayúscula";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "La contraseña debe tener al menos una minúscula";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "La contraseña debe tener al menos un número";
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = "La contraseña debe tener al menos un carácter especial";
    }
    
    return $errors;
}

/**
 * Generar mensaje flash para la sesión
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type, // success, error, warning, info
        'message' => $message
    ];
}

/**
 * Mostrar y limpiar mensaje flash
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Mostrar mensaje flash en HTML
 */
function displayFlashMessage() {
    $flash = getFlashMessage();
    if ($flash) {
        echo '<div class="alert alert-' . $flash['type'] . '">';
        echo htmlspecialchars($flash['message']);
        echo '</div>';
    }
}

/**
 * Obtener datos del usuario por ID
 */
function getUserById($pdo, $userId) {
    try {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $pdo->executeQuery($sql);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        error_log("Error obteniendo usuario: " . $e->getMessage());
        return null;
    }
}

/**
 * Actualizar última actividad del usuario
 */
function updateLastActivity($pdo, $userId) {
    try {
        $sql = "UPDATE usuarios SET last_activity = NOW() WHERE id = :id";
        $stmt = $pdo->executeQuery($sql);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error actualizando última actividad: " . $e->getMessage());
        return false;
    }
}

/**
 * Verificar si la sesión ha expirado por inactividad
 */
function checkSessionTimeout($timeout_minutes = 30) {
    if (isset($_SESSION['last_activity'])) {
        $inactive_time = time() - $_SESSION['last_activity'];
        if ($inactive_time > ($timeout_minutes * 60)) {
            session_destroy();
            return true; // Sesión expirada
        }
    }
    $_SESSION['last_activity'] = time();
    return false; // Sesión activa
}
?>