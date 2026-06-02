<form id="form1" name="form1" method="post" action="procesar_registro.php">
    <!-- Token CSRF manual -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
    <input type="hidden" name="Accion" value="Guardar">
    
    <fieldset>
        <legend>Nombre:</legend>
        <input name="nombre" id="nombre" type="text" required />
    </fieldset>
    <br>
    
    <fieldset>
        <legend>Apellido:</legend>
        <input name="apellido" id="apellido" type="text" required />
    </fieldset>
    <br>
    
    <fieldset>
        <legend>Usuario:</legend>
        <input name="usuario" id="usuario" type="text" required />
    </fieldset>
    <br>
    
    <fieldset>
        <legend>Email personal:</legend>
        <input name="email1" id="email1" type="email" required />
    </fieldset>
    <br>
    
    <fieldset>
        <legend>Contraseña:</legend>
        <input name="clave" id="clave" type="password" required />
    </fieldset>
    <br>
    
    <fieldset>
        <legend>Repetir Contraseña:</legend>
        <input name="clave_again" id="clave_again" type="password" required />
    </fieldset>
    <br>
    
    <fieldset>
        <legend>Sexo:</legend>
        <input type="radio" name="sexo" value="M" required> Masculino
        <input type="radio" name="sexo" value="F"> Femenino
    </fieldset>
    <br>
    
    <button type="submit">📝 Registrarse</button>
    <button type="reset">🗑️ Limpiar</button>
</form>

<script>
$(document).ready(function () {
    $("#form1").validate({
        rules: {
            nombre: "required",
            apellido: "required",
            usuario: "required",
            clave: "required",
            clave_again: {
                equalTo: "#clave"
            },
            email1: {
                required: true,
                email: true
            },
            sexo: "required"
        },
        messages: {
            nombre: "Ingrese su nombre",
            apellido: "Ingrese su apellido",
            usuario: "Ingrese un nombre de usuario",
            clave: "Ingrese una contraseña",
            clave_again: "Las contraseñas no coinciden",
            email1: "Ingrese un email válido",
            sexo: "Seleccione su sexo"
        }
    });
});
</script>

<style>
    fieldset {
        margin: 8px 0;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    legend {
        font-weight: bold;
        color: #333;
        padding: 0 10px;
    }
    input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    input:focus {
        outline: none;
        border-color: #667eea;
    }
    button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    button[type="submit"] {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    button[type="reset"] {
        background: #6c757d;
        color: white;
    }
    label.error {
        color: red;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
    input.error {
        border-color: red;
    }
</style>