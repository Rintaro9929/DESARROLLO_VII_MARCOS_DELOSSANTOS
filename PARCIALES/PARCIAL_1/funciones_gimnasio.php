<?php
function calcular_promocion($antiguedad_meses){
    if ($antiguedad_meses >=24 ) {
        return "20% de descuento";
    } elseif($antiguedad_meses >= 13 && $antiguedad_meses <= 24) {
        return "12% de descuento";
    }
    elseif ($antiguedad_meses >= 3 && $antiguedad_meses <= 12) {
        return "8% de descuento";
    } elseif ($antiguedad_meses >= 3) {
        return "Sin descuento";
    }
}


function calcular_seguro_medico($cuota_base){
    return $cuota_base * 0.05;
}

function calcular_cuota_final($cuota_base, $descuento_porcentaje, $seguro_medico) {
  
    $cuota_base = max(0, floatval($cuota_base));
    $descuento_porcentaje = max(0, floatval($descuento_porcentaje));
    $seguro_medico = max(0, floatval($seguro_medico));

    $descuento = ($cuota_base * $descuento_porcentaje) / 100;
    $cuota_con_descuento = $cuota_base - $descuento;
    return $cuota_con_descuento + $seguro_medico;
}

?>