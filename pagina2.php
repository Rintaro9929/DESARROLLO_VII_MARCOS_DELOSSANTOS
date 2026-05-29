<?php
if (isset($_COOKIE['usuario'])){
    echo "El usuario es: ".$_COOKIE['usuario']."<br>";

    echo "Esta configurada la Cookie<br>";

}
echo "<br>";

//Validar si hay cookies guradas

if (count($_COOKIE) > 0){
    echo "hay ".count($_COOKIE)." cookies guardas";
}

?>