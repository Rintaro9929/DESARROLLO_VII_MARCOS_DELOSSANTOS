<?php
session_start();
ini_set('display_errors', 1);
ini_set("log_errors", 1);

// Cargar clases
require_once(__DIR__ . "/../classes/myConexionPDO.php");
require_once(__DIR__ . "/../classes/SanitizarEntrada.php");
require_once(__DIR__ . "/../classes/ClaseRegistrese.php");
require_once(__DIR__ . "/../classes/CSRFProtection.php");

// Verificar CSRF
CSRFProtection::verificarFormulario();

// Cargar Composer
require_once(__DIR__ . "/../vendor/autoload.php");

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;  // ✅ Agregar esta línea

$arrMensaje = array();

try {
    $pdo = new mod_db();
    $MyRegistro = new RegistroUsuario($_POST, $pdo, $arrMensaje);

    if (count($arrMensaje) == 0) {
        $Accion = isset($_POST['Accion']) ? $_POST['Accion'] : '';

        if ($Accion == "Guardar") {
            // Verificar si el email ya existe
            if ($MyRegistro->verificarEmailExistente()) {
                die("❌ El correo electrónico ya está registrado. <a href='registrese.php'>Volver</a>");
            }

            // Guardar datos del usuario
            $userId = $MyRegistro->Guardar_RegistroUsuario();

            if ($userId) {
                // Generar secreto 2FA
                $g = new GoogleAuthenticator();
                $secret = $g->generateSecret();

                if ($MyRegistro->GuardarMySecreto($secret)) {
                    $nombre_usuario = $MyRegistro->getUsuario();
                    $correo_usuario = $MyRegistro->getCorreo();
                    $nombre_aplicacion = "MiSistemaAutenticacion";

                    // ✅ NUEVA FORMA (recomendada) - sin advertencia de deprecación
                    $url = GoogleQrUrl::generate($correo_usuario, $secret, $nombre_aplicacion);
                    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($url);
                    ?>
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <title>✅ Registro Exitoso - Configurar 2FA</title>
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
                            .container {
                                background: white;
                                border-radius: 20px;
                                padding: 30px;
                                text-align: center;
                                max-width: 450px;
                                width: 100%;
                                box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                            }
                            .qr-code {
                                background: white;
                                padding: 15px;
                                border-radius: 10px;
                                margin: 20px 0;
                            }
                            .secret {
                                background: #f5f5f5;
                                padding: 10px;
                                border-radius: 8px;
                                font-family: monospace;
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
                                margin-top: 15px;
                            }
                            .warning {
                                background: #fff3cd;
                                color: #856404;
                                padding: 10px;
                                border-radius: 8px;
                                font-size: 12px;
                                margin-top: 20px;
                            }
                            h2 { color: #333; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h2>✅ ¡Registro Exitoso!</h2>
                            <p>Bienvenido <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                            <p>🔐 Escanea este QR con <strong>Google Authenticator</strong></p>
                            <div class="qr-code">
                                <img src="<?php echo $qr_url; ?>" alt="QR Code">
                            </div>
                            <div class="secret">
                                <strong>Código secreto:</strong><br>
                                <?php echo chunk_split($secret, 4, ' '); ?>
                            </div>
                            <a href="../login/login.php" class="btn">🔑 Ir a Iniciar Sesión</a>
                            <div class="warning">
                                ⚠️ Guarda este código en un lugar seguro. No lo compartas.
                            </div>
                        </div>
                    </body>
                    </html>
                    <?php
                    exit;
                } else {
                    echo "Error al guardar 2FA";
                }
            } else {
                echo "Error al registrar usuario";
            }
        }
    } else {
        echo "<div style='color:red; padding:20px;'><h3>Errores:</h3><ul>";
        foreach ($arrMensaje as $val) {
            echo "<li>" . htmlspecialchars($val) . "</li>";
        }
        echo "</ul><a href='registrese.php'>Volver</a></div>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>