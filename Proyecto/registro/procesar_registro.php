<?php
session_start();
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/../logs/php_error.log");

require_once("../classes/myConexionPDO.php");
require_once("../classes/SanitizarEntrada.php");
require_once("../classes/ClaseRegistrese.php");
require_once("../classes/CSRFProtection.php");

// Verificar CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRFProtection::verificarFormulario();
}

require_once("../vendor/autoload.php");

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

$arrMensaje = array();

try {
    $pdo = new mod_db();
    $MyRegistro = new RegistroUsuario($_POST, $pdo, $arrMensaje);

    if (count($arrMensaje) == 0) {
        $Accion = isset($_POST['Accion']) ? $_POST['Accion'] : '';

        if ($Accion == "Guardar") {
            // Verificar si el email ya existe
            if ($MyRegistro->verificarEmailExistente()) {
                die("El correo electrónico ya está registrado");
            }

            // Guardar datos del usuario
            $userId = $MyRegistro->Guardar_RegistroUsuario();

            if ($userId) {
                // Generar el secreto para 2FA
                $g = new GoogleAuthenticator();
                $secret = $g->generateSecret();

                if ($MyRegistro->GuardarMySecreto($secret)) {
                    $nombre_usuario = $MyRegistro->getUsuario();
                    $correo_usuario = $MyRegistro->getCorreo();
                    $nombre_aplicacion = "MiSistemaAutenticacion";

                    // Generar URL para QR
                    $url = GoogleQrUrl::generate($correo_usuario, $secret, $nombre_aplicacion);
                    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($url);
                    ?>
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Configurar Autenticación 2FA</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                min-height: 100vh;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                margin: 0;
                                padding: 20px;
                            }
                            .qr-container {
                                background: white;
                                border-radius: 20px;
                                padding: 30px;
                                text-align: center;
                                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                                max-width: 400px;
                                width: 100%;
                            }
                            .qr-container img {
                                border-radius: 10px;
                                margin: 20px 0;
                                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                            }
                            .qr-label {
                                background: #f0f0f0;
                                padding: 15px;
                                border-radius: 10px;
                                margin: 15px 0;
                            }
                            .secret-code {
                                background: #e8e8e8;
                                padding: 10px;
                                border-radius: 5px;
                                font-family: monospace;
                                font-size: 14px;
                                word-break: break-all;
                                margin: 10px 0;
                            }
                            .btn {
                                display: inline-block;
                                padding: 12px 25px;
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                font-weight: bold;
                                margin-top: 15px;
                                transition: transform 0.2s;
                            }
                            .btn:hover {
                                transform: scale(1.05);
                            }
                            h2 {
                                color: #333;
                                margin-bottom: 10px;
                            }
                            .warning {
                                color: #e74c3c;
                                font-size: 12px;
                                margin-top: 15px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="qr-container">
                            <h2>✅ ¡Registro Exitoso!</h2>
                            <p>Bienvenido(a) <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                            
                            <div class="qr-label">
                                <p><strong>🔐 Autenticación de Dos Factores (2FA)</strong></p>
                                <p>Escanea este código QR con <strong>Google Authenticator</strong></p>
                            </div>
                            
                            <img src="<?php echo $qr_url; ?>" alt="Código QR para Google Authenticator">
                            
                            <div class="secret-code">
                                <strong>Código secreto (si no puedes escanear el QR):</strong><br>
                                <?php echo chunk_split($secret, 4, ' '); ?>
                            </div>
                            
                            <p><strong>Instrucciones:</strong></p>
                            <ol style="text-align: left;">
                                <li>Descarga Google Authenticator desde tu tienda de apps</li>
                                <li>Abre la app y presiona "+" para agregar una cuenta</li>
                                <li>Selecciona "Escanear código QR"</li>
                                <li>Escanea este código con tu celular</li>
                                <li>La app generará un código de 6 dígitos que cambiará cada 30 segundos</li>
                            </ol>
                            
                            <a href="../login.php" class="btn">🔑 Ir al Inicio de Sesión</a>
                            
                            <div class="warning">
                                ⚠️ IMPORTANTE: Guarda este código secreto en un lugar seguro. 
                                No lo compartas con nadie. Si pierdes acceso a tu app, necesitarás este código para recuperar tu cuenta.
                            </div>
                        </div>
                    </body>
                    </html>
                    <?php
                } else {
                    echo "Error al guardar la configuración de seguridad";
                }
            } else {
                echo "Error al registrar el usuario";
            }
        }
    } else {
        // Mostrar errores
        echo "<div style='color:red; padding:20px;'>";
        echo "<h3>Errores en el registro:</h3><ul>";
        foreach ($arrMensaje as $val) {
            echo "<li>" . htmlspecialchars($val) . "</li>";
        }
        echo "</ul><a href='registrese.php'>Volver al formulario</a>";
        echo "</div>";
    }
} catch (Exception $e) {
    error_log("Error en registro: " . $e->getMessage());
    echo "Ha ocurrido un error al procesar la solicitud. Por favor, intente más tarde.";
} finally {
    $pdo = null;
    $MyRegistro = null;
}
?>