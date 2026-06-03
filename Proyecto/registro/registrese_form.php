<form id="form1" name="form1" method="post" action="procesar_registro.php">
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
            clave_again: { equalTo: "#clave" },
            email1: { required: true, email: true },
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