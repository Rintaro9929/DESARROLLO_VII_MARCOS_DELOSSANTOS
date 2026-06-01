<?php
// Archivo: comunes/footer.php
// Footer del sitio web
?>
    </div> <!-- Cierre del main-container -->
    
    <div class="footer">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> - Sistema de Autenticación con Dos Factores (2FA)</p>
            <p>Desarrollado para la Facultad de Ingeniería en Sistemas - Universidad Tecnológica de Panamá</p>
            <p>🔐 Protegido con autenticación de dos factores | Google Authenticator</p>
        </div>
    </div>
    
    <!-- Scripts adicionales -->
    <script>
        // Función para mostrar mensajes
        function showMessage(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = message;
            
            const container = document.querySelector('.main-container');
            if (container) {
                container.insertBefore(alertDiv, container.firstChild);
                
                // Auto-cerrar después de 5 segundos
                setTimeout(() => {
                    alertDiv.style.opacity = '0';
                    setTimeout(() => alertDiv.remove(), 300);
                }, 5000);
            }
        }
        
        // Función para validar formularios de manera general
        function validarFormulario(formId) {
            $(`#${formId}`).validate({
                errorClass: 'error',
                validClass: 'valid',
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('error-message');
                    error.insertAfter(element);
                }
            });
        }
        
        // Protección contra doble envío de formularios
        $(document).ready(function() {
            $('form').on('submit', function() {
                const $btn = $(this).find('button[type="submit"], input[type="submit"]');
                if ($btn.length) {
                    $btn.prop('disabled', true);
                    $btn.html('<span class="spinner"></span> Procesando...');
                }
            });
        });
    </script>
    
    <style>
        .error-message {
            color: #dc3545;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }
        
        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer p {
            margin: 5px 0;
        }
    </style>
</body>
</html>