<form id="form1" name="form1" method="post" action="procesar_registro.php">
    <?php echo CSRFProtection::campoHidden(); ?>
    
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
    
    <input type="submit" name="Submit" value="Registrarse">
    <input type="reset" name="Reset" value="Limpiar">
</form>

<script type="text/javascript">
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
            nombre: "Por favor ingrese su nombre",
            apellido: "Por favor ingrese su apellido",
            usuario: "Por favor ingrese un nombre de usuario",
            clave: "Por favor ingrese una contraseña",
            clave_again: "Las contraseñas no coinciden",
            email1: "Por favor ingrese un email válido",
            sexo: "Por favor seleccione su sexo"
        }
    });
});
</script>

<style>
    #field, label { float: left; font-family: Arial, Helvetica, sans-serif; font-size: small; }
    label { width: 150px; height: 10px; }
    br { clear:both; }
    input.submit { float: none; }
    input.error { border: 1px solid red; width: auto; }
    label.error {
        background: url('../img/error.gif') no-repeat;
        padding-left: 16px;
        margin-left: .3em;
        color: #FF0000;
    }
    fieldset {
        margin: 5px;
        padding: 8px;
        border: 1px solid #ccc;
    }
    legend {
        font-weight: bold;
        color: #333;
    }
</style>