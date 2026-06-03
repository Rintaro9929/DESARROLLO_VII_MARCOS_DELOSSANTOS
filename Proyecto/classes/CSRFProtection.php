<?php
/**
 * Sistema de protección CSRF
 * Ubicación: classes/CSRFProtection.php
 */

class CSRFProtection {
    
    /**
     * Generar token CSRF
     */
    public static function generarToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Obtener token actual
     */
    public static function obtenerToken() {
        self::generarToken();
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validar token CSRF
     * ✅ Agregado tipo string al parámetro
     */
    public static function validarToken(string $token_recibido) {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token_recibido);
    }
    
    /**
     * Generar campo hidden para formularios
     */
    public static function campoHidden() {
        $token = self::generarToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Verificar y procesar formulario
     */
    public static function verificarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token_recibido = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
            
            if (!self::validarToken($token_recibido)) {
                http_response_code(403);
                die('<h2>❌ Error de seguridad</h2><p>Token CSRF inválido.</p>');
            }
        }
    }
    
    /**
     * Verificar token para peticiones AJAX
     */
    public static function verificarAjax() {
        $token = '';
        
        if (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        } elseif (isset($_POST['csrf_token'])) {
            $token = $_POST['csrf_token'];
        }
        
        if (!self::validarToken($token)) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Token CSRF inválido']);
            exit;
        }
    }
    
    /**
     * Regenerar token
     */
    public static function regenerarToken() {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Generar meta tag para JavaScript
     */
    public static function metaTag() {
        $token = self::generarToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Alias para campoHidden()
     */
    public static function campo() {
        return self::campoHidden();
    }
    
    /**
     * Alias para generarToken()
     */
    public static function getToken() {
        return self::generarToken();
    }
}

// Funciones de conveniencia
function csrf_token() {
    return CSRFProtection::obtenerToken();
}

function csrf_field() {
    return CSRFProtection::campoHidden();
}

function verificar_csrf() {
    CSRFProtection::verificarFormulario();
}

function csrf_meta() {
    return CSRFProtection::metaTag();
}
?>