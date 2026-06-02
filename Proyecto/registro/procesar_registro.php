<?php
session_start();
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . "/../logs/php_error.log");

require_once(__DIR__ . "/../classes/myConexionPDO.php");
require_once(__DIR__ . "/../classes/SanitizarEntrada.php");
require_once(__DIR__ . "/../classes/ClaseRegistrese.php");
require_once(__DIR__ . "/../classes/CSRFProtection.php");

// Verificar CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    CSRFProtection::verificarFormulario();
}

// ✅ AHORA SÍ, el archivo vendor/autoload.php YA EXISTE
require_once(__DIR__ . "/../vendor/autoload.php");

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

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
                // ✅ USAR LA LIBRERÍA DE GOOGLE AUTHENTICATOR
                $g = new GoogleAuthenticator();
                $secret = $g->generateSecret();

                if ($MyRegistro->GuardarMySecreto($secret)) {
                    $nombre_usuario = $MyRegistro->getUsuario();
                    $correo_usuario = $MyRegistro->getCorreo();
                    $nombre_aplicacion = "MiSistemaAutenticacion";

                    // Generar URL para QR usando la librería
                    $url = $g->getUrl($correo_usuario, $nombre_aplicacion, $secret);
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
                                max-width: 450px;
                                width: 100%;
                            }
                            .qr-container img {
                                border-radius: 10px;
                                margin: 20px 0;
                                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                                background: white;
                                padding: 10px;
                            }
                            .qr-label {
                                background: #f0f7ff;
                                padding: 15px;
                                border-radius: 10px;
                                margin: 15px 0;
                            }
                            .secret-code {
                                background: #f5f5f5;
                                padding: 12px;
                                border-radius: 8px;
                                font-family: 'Courier New', monospace;
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
                                background: #fff3cd;
                                color: #856404;
                                padding: 12px;
                                border-radius: 8px;
                                font-size: 12px;
                                margin-top: 20px;
                                text-align: left;
                            }
                            .success-icon {
                                font-size: 50px;
                                margin-bottom: 10px;
                            }
                            ol {
                                text-align: left;
                                margin: 15px 0;
                                padding-left: 20px;
                            }
                            li {
                                margin: 8px 0;
                                font-size: 13px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="qr-container">
                            <div class="success-icon">✅</div>
                            <h2>¡Registro Exitoso!</h2>
                            <p>Bienvenido(a) <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                            
                            <div class="qr-label">
                                <p><strong>🔐 Autenticación de Dos Factores (2FA)</strong></p>
                                <p>Escanea este código QR con <strong>Google Authenticator</strong></p>
                            </div>
                            
                            <img src="<?php echo $qr_url; ?>" alt="Código QR para Google Authenticator">
                            
                            <div class="secret-code">
                                <strong>📱 Código secreto (si no puedes escanear):</strong><br>
                                <?php echo chunk_split($secret, 4, ' '); ?>
                            </div>
                            
                            <div style="text-align: left;">
                                <strong>📋 Instrucciones:</strong>
                                <ol>
                                    <li>📲 Descarga <strong>Google Authenticator</strong> desde tu tienda de apps</li>
                                    <li>➕ Abre la app y presiona "+" para agregar una cuenta</li>
                                    <li>📷 Selecciona <strong>"Escanear código QR"</strong></li>
                                    <li>🔍 Escanea este código con tu celular</li>
                                    <li>⏰ La app generará un código de 6 dígitos que cambia cada 30 segundos</li>
                                </ol>
                            </div>
                            
                            <a href="../login/login.php" class="btn">🔑 Ir al Inicio de Sesión</a>
                            
                            <div class="warning">
                                ⚠️ <strong>IMPORTANTE:</strong> Guarda este código secreto en un lugar seguro. 
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
        echo "<div style='color:red; padding:20px; background:#fff; border-radius:10px; max-width:500px; margin:50px auto;'>";
        echo "<h3>❌ Errores en el registro:</h3><ul>";
        foreach ($arrMensaje as $val) {
            echo "<li>" . htmlspecialchars($val) . "</li>";
        }
        echo "</ul><a href='registrese.php'>← Volver al formulario</a>";
        echo "</div>";
    }
} catch (Exception $e) {
    error_log("Error en registro: " . $e->getMessage());
    echo "<div style='color:red; padding:20px; background:#fff; border-radius:10px; max-width:500px; margin:50px auto;'>";
    echo "<h3>❌ Ha ocurrido un error</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='registrese.php'>← Volver al formulario</a>";
    echo "</div>";
} finally {
    $pdo = null;
    $MyRegistro = null;
}
?>