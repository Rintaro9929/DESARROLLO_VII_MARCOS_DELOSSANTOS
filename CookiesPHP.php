<?php

if (isset($_POST["enviar"])){

$usuario = htmlentities($_POST["usuario"]);

//Configuar una cookie - crear la cookie
setcookie('usuario', $usuario, time() + 3600);
header("location:pagina2.php");

}//

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Introduzca el Usuario">
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>
</html>