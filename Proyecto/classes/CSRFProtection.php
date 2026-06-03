<?php

class CSRFProtection {
    
    public static function generarToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    public static function obtenerToken() {
        self::generarToken();
        return $_SESSION['csrf_token'];
    }
    
    public static function validarToken($token_recibido) {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token_recibido);
    }
    
    public static function campoHidden() {
        $token = self::generarToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
    
    public static function verificarFormulario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token_recibido = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
            
            if (!self::validarToken($token_recibido)) {
                http_response_code(403);
                die('<h2>Error de seguridad</h2><p>Token CSRF inválido.</p>');
            }
        }
    }
    
    public static function regenerarToken() {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
    
    public static function metaTag() {
        $token = self::generarToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token) . '">';
    }
}
?>