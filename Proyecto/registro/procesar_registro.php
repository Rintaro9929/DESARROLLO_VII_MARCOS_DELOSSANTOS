<?php
session_start();
ini_set('display_errors', 1);

require_once(__DIR__ . "/../classes/myConexionPDO.php");
require_once(__DIR__ . "/../classes/SanitizarEntrada.php");
require_once(__DIR__ . "/../classes/ClaseRegistrese.php");
require_once(__DIR__ . "/../classes/CSRFProtection.php");

// Verificar CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token_recibido = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token_recibido)) {
        die("Error de seguridad: Token CSRF inválido");
    }
}

$arrMensaje = array();

try {
    $pdo = new mod_db();
    $MyRegistro = new RegistroUsuario($_POST, $pdo, $arrMensaje);

    if (count($arrMensaje) == 0) {
        $Accion = isset($_POST['Accion']) ? $_POST['Accion'] : '';

        if ($Accion == "Guardar") {
            if ($MyRegistro->verificarEmailExistente()) {
                die("❌ El correo electrónico ya está registrado. <a href='registrese.php'>Volver</a>");
            }

            $userId = $MyRegistro->Guardar_RegistroUsuario();

            if ($userId) {
                // Generar secreto BASE32 manualmente
                function generarSecretBase32($length = 16) {
                    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
                    $secret = '';
                    for ($i = 0; $i < $length; $i++) {
                        $secret .= $chars[random_int(0, strlen($chars) - 1)];
                    }
                    return $secret;
                }
                
                $secret = generarSecretBase32(16);
                
                if ($MyRegistro->GuardarMySecreto($secret)) {
                    $nombre_usuario = $MyRegistro->getUsuario();
                    $correo_usuario = $MyRegistro->getCorreo();
                    $nombre_aplicacion = "MiSistemaAutenticacion";

                    // URL para Google Authenticator
                    $url = "otpauth://totp/" . rawurlencode($nombre_aplicacion . ":" . $correo_usuario) . "?secret=" . $secret . "&issuer=" . rawurlencode($nombre_aplicacion);
                    
                    // Múltiples opciones de QR (una debería funcionar)
                    $qr_api1 = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($url);
                    $qr_api2 = "https://quickchart.io/qr?text=" . urlencode($url) . "&size=250";
                    $qr_api3 = "https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=" . urlencode($url);
                    ?>
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <title>✅ Registro Exitoso - Configurar 2FA</title>
                        <style>
                            *{margin:0;padding:0;box-sizing:border-box}
                            body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#667eea,#764ba2);min-height:100vh;display:flex;justify-content:center;align-items:center;padding:20px}
                            .container{background:#fff;border-radius:20px;padding:35px;max-width:600px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
                            h2{color:#333;margin-bottom:10px;text-align:center}
                            .qr-box{background:#f8f9fa;padding:20px;border-radius:15px;margin:20px 0;text-align:center}
                            .qr-box img{background:#fff;padding:15px;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);max-width:100%}
                            .secret-box{background:#e9ecef;padding:15px;border-radius:10px;margin:15px 0;text-align:center}
                            .secret-code{font-family:'Courier New',monospace;font-size:20px;font-weight:bold;letter-spacing:3px;background:#fff;padding:12px;border-radius:8px;margin-top:10px;word-break:break-all}
                            .manual-box{background:#d1ecf1;padding:15px;border-radius:10px;margin:15px 0;text-align:left}
                            .btn{display:inline-block;padding:12px 30px;background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;text-decoration:none;border-radius:8px;margin-top:15px;font-weight:bold}
                            .warning{background:#fff3cd;color:#856404;padding:12px;border-radius:8px;font-size:13px;margin-top:20px}
                            hr{margin:20px 0;border-color:#eee}
                            .qr-tabs{display:flex;gap:10px;margin-bottom:15px;justify-content:center}
                            .qr-tab{background:#e9ecef;padding:8px 15px;border-radius:20px;cursor:pointer;font-size:12px}
                            .qr-tab.active{background:#667eea;color:#fff}
                            .qr-image{display:none}
                            .qr-image.active{display:block}
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h2>✅ ¡Registro Exitoso!</h2>
                            <p style="text-align:center;color:#666">Bienvenido <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></p>
                            
                            <hr>
                            
                            <h3 style="text-align:center">🔐 Configurar Google Authenticator</h3>
                            
                            <!-- Código QR - Múltiples opciones -->
                            <div class="qr-box">
                                <p><strong>📱 Escanea este código QR con Google Authenticator</strong></p>
                                
                                <div class="qr-tabs">
                                    <div class="qr-tab active" onclick="mostrarQR(1)">Opción 1</div>
                                    <div class="qr-tab" onclick="mostrarQR(2)">Opción 2</div>
                                    <div class="qr-tab" onclick="mostrarQR(3)">Opción 3</div>
                                </div>
                                
                                <div id="qr1" class="qr-image active">
                                    <img src="<?php echo $qr_api1; ?>" alt="QR Code Opción 1">
                                    <p style="font-size:12px;color:#666;margin-top:10px">api.qrserver.com</p>
                                </div>
                                <div id="qr2" class="qr-image">
                                    <img src="<?php echo $qr_api2; ?>" alt="QR Code Opción 2">
                                    <p style="font-size:12px;color:#666;margin-top:10px">quickchart.io</p>
                                </div>
                                <div id="qr3" class="qr-image">
                                    <img src="<?php echo $qr_api3; ?>" alt="QR Code Opción 3">
                                    <p style="font-size:12px;color:#666;margin-top:10px">Google Charts</p>
                                </div>
                            </div>
                            
                            <!-- Configuración MANUAL -->
                            <div class="manual-box">
                                <p><strong>⚠️ ¿Ningún QR funciona? Configura MANUALMENTE:</strong></p>
                                <ol style="margin-left:20px;margin-top:10px">
                                    <li>Abre <strong>Google Authenticator</strong></li>
                                    <li>Presiona el botón <strong>"+"</strong> → <strong>"Ingresar clave de configuración"</strong></li>
                                    <li><strong>Cuenta:</strong> <code><?php echo htmlspecialchars($correo_usuario); ?></code></li>
                                    <li><strong>Clave:</strong> <code style="font-size:16px"><?php echo $secret; ?></code></li>
                                    <li><strong>Tipo:</strong> <strong>Basado en tiempo (TOTP)</strong></li>
                                    <li>Presiona <strong>"Agregar"</strong></li>
                                </ol>
                            </div>
                            
                            <!-- Código Secreto -->
                            <div class="secret-box">
                                <strong>🔑 Código Secreto (para copiar y pegar):</strong>
                                <div class="secret-code"><?php echo chunk_split($secret, 4, ' '); ?></div>
                                <button onclick="copiarAlPortapapeles('<?php echo $secret; ?>')" style="margin-top:10px;padding:5px 15px;background:#28a745;color:#fff;border:none;border-radius:5px;cursor:pointer">📋 Copiar código</button>
                            </div>
                            
                            <p style="text-align:center;color:#28a745;font-size:14px">
                                ✅ Después de configurar, la app generará un <strong>código de 6 dígitos</strong> que cambia cada 30 segundos
                            </p>
                            
                            <div style="text-align:center">
                                <a href="../login/login.php" class="btn">🔑 Ir a Iniciar Sesión</a>
                            </div>
                            
                            <div class="warning">
                                ⚠️ <strong>IMPORTANTE:</strong> Guarda este código secreto en un lugar seguro. 
                                No lo compartas con nadie.
                            </div>
                        </div>
                        
                        <script>
                            function mostrarQR(opcion) {
                                // Ocultar todos
                                document.getElementById('qr1').classList.remove('active');
                                document.getElementById('qr2').classList.remove('active');
                                document.getElementById('qr3').classList.remove('active');
                                // Quitar active de los tabs
                                let tabs = document.querySelectorAll('.qr-tab');
                                tabs.forEach(tab => tab.classList.remove('active'));
                                // Mostrar el seleccionado
                                document.getElementById('qr' + opcion).classList.add('active');
                                tabs[opcion-1].classList.add('active');
                            }
                            
                            function copiarAlPortapapeles(texto) {
                                navigator.clipboard.writeText(texto);
                                alert('✅ Código copiado al portapapeles');
                            }
                        </script>
                    </body>
                    </html>
                    <?php
                    exit;
                } else {
                    echo "Error al guardar la configuración de seguridad";
                }
            } else {
                echo "Error al registrar el usuario";
            }
        }
    } else {
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